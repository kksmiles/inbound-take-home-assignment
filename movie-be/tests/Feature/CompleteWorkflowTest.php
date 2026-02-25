<?php

use App\Models\User;
use App\Services\Omdb\OmdbClient;

describe('Complete User Workflows', function () {
    describe('User Registration to Movie Favoriting Flow', function () {
        test('complete workflow: register → verify email → search movies → favorite → unfavorite', function () {
            // Mock OMDB responses for the workflow
            $searchResponse = [
                'Search' => [
                    [
                        'Title' => 'The Matrix',
                        'Year' => '1999',
                        'imdbID' => 'tt0133093',
                        'Type' => 'movie',
                        'Poster' => 'https://example.com/poster1.jpg',
                    ],
                    [
                        'Title' => 'The Matrix Reloaded',
                        'Year' => '2003',
                        'imdbID' => 'tt0234215',
                        'Type' => 'movie',
                        'Poster' => 'https://example.com/poster2.jpg',
                    ],
                ],
                'totalResults' => '2',
                'Response' => 'True',
            ];

            $detailResponse = [
                'Title' => 'The Matrix',
                'Year' => '1999',
                'imdbID' => 'tt0133093',
                'Type' => 'movie',
                'Poster' => 'https://example.com/poster1.jpg',
                'Plot' => 'A computer programmer is transported to a simulated reality.',
                'Director' => 'Lana Wachowski, Lilly Wachowski',
                'Response' => 'True',
            ];

            $this->mock(OmdbClient::class, function ($mock) use ($searchResponse, $detailResponse) {
                $mock->shouldReceive('search')
                    ->with('matrix', 1)
                    ->andReturn($searchResponse);

                $mock->shouldReceive('getByImdbId')
                    ->with('tt0133093')
                    ->andReturn($detailResponse);
            });

            // Step 1: User registration
            $registrationResponse = $this->postJson('/api/auth/register', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

            $registrationResponse->assertStatus(201);
            $userId = $registrationResponse->json('data.id');

            // Step 2: User login
            $loginResponse = $this->postJson('/api/auth/login', [
                'email' => 'john@example.com',
                'password' => 'password123',
            ]);

            $loginResponse->assertStatus(200);
            $token = $loginResponse->json('data.token');

            // Step 3: Verify email (simulate)
            $user = User::find($userId);
            $user->markEmailAsVerified();

            // Step 4: Search for movies (no auth required)
            $searchResponse = $this->getJson('/api/movies/search?q=matrix');

            $searchResponse->assertStatus(200)
                ->assertJsonCount(2, 'data')
                ->assertJson([
                    'data' => [
                        [
                            'imdb_id' => 'tt0133093',
                            'title' => 'The Matrix',
                        ],
                    ],
                ]);

            // Step 5: Get movie details
            $movieDetailResponse = $this->getJson('/api/movies/tt0133093');

            $movieDetailResponse->assertJson([
                'data' => [
                    'imdb_id' => 'tt0133093',
                    'title' => 'The Matrix',
                    'year' => '1999',
                ],
            ]);

            // Step 6: Add movie to favorites (requires auth)
            $favoriteResponse = $this->withHeaders(['Authorization' => "Bearer $token"])
                ->postJson('/api/favorites', [
                    'imdb_id' => 'tt0133093',
                ]);

            $favoriteResponse->assertStatus(201);

            // Step 7: Get user's favorites
            $favoritesResponse = $this->withHeaders(['Authorization' => "Bearer $token"])
                ->getJson('/api/favorites');

            $favoritesResponse->assertStatus(200)
                ->assertJsonCount(1, 'data')
                ->assertJson([
                    'data' => [
                        [
                            'movie' => [
                                'imdb_id' => 'tt0133093',
                                'title' => 'The Matrix',
                            ],
                        ],
                    ],
                ]);

            // Step 8: Remove from favorites
            $removeFavoriteResponse = $this->withHeaders(['Authorization' => "Bearer $token"])
                ->deleteJson('/api/favorites/tt0133093');

            $removeFavoriteResponse->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Favorite removed.',
                ]);

            // Step 9: Verify favorites list is empty
            $emptyFavoritesResponse = $this->withHeaders(['Authorization' => "Bearer $token"])
                ->getJson('/api/favorites');

            $emptyFavoritesResponse->assertStatus(200)
                ->assertJson(['data' => []]);

            // Step 10: User logout
            $logoutResponse = $this->withHeaders(['Authorization' => "Bearer $token"])
                ->postJson('/api/auth/logout');

            $logoutResponse->assertStatus(200)
                ->assertJson(['message' => 'Logged out']);
        });

        test('unverified user cannot manage favorites', function () {
            $this->mock(OmdbClient::class, function ($mock) {
                $mock->shouldReceive('getByImdbId')
                    ->with('tt0133093')
                    ->andReturn([
                        'Title' => 'The Matrix',
                        'Year' => '1999',
                        'imdbID' => 'tt0133093',
                        'Type' => 'movie',
                        'Response' => 'True',
                    ]);
            });

            // Create unverified user
            $user = User::factory()->unverified()->create();

            // Attempt to add favorite
            $response = $this->actingAs($user, 'api')
                ->postJson('/api/favorites', [
                    'imdb_id' => 'tt0133093',
                ]);

            $response->assertStatus(403)
                ->assertJson([
                    'message' => 'Email verification required to manage favorites.',
                ]);

            // Verify no favorites were created
            expect($user->favorites)->toHaveCount(0);
        });
    });

    describe('Multiple Users Favorite Management', function () {
        test('users can favorite same movie independently', function () {
            // Create two verified users
            $user1 = User::factory()->create(['email' => 'user1@example.com']);
            $user2 = User::factory()->create(['email' => 'user2@example.com']);

            // Both users favorite the same movie
            $this->actingAs($user1, 'api')
                ->postJson('/api/favorites', ['imdb_id' => 'tt0133093'])
                ->assertStatus(201);

            $this->actingAs($user2, 'api')
                ->postJson('/api/favorites', ['imdb_id' => 'tt0133093'])
                ->assertStatus(201);

            // Both should have the movie in their favorites
            $user1Favorites = $this->actingAs($user1, 'api')
                ->getJson('/api/favorites');

            $user2Favorites = $this->actingAs($user2, 'api')
                ->getJson('/api/favorites');

            $user1Favorites->assertJsonCount(1, 'data');
            $user2Favorites->assertJsonCount(1, 'data');

            expect($user1->favorites)->toHaveCount(1);
            expect($user2->favorites)->toHaveCount(1);

            // User1 removes favorite
            $this->actingAs($user1, 'api')
                ->deleteJson('/api/favorites/tt0133093')
                ->assertStatus(200);

            // User1 should have no favorites, User2 should still have one
            $user1FavoritesAfter = $this->actingAs($user1, 'api')
                ->getJson('/api/favorites')
                ->assertJsonCount(0, 'data');

            $user2FavoritesAfter = $this->actingAs($user2, 'api')
                ->getJson('/api/favorites')
                ->assertJsonCount(1, 'data');
        });
    });

    describe('Error Handling Workflows', function () {
        test('handles OMDB API failures gracefully', function () {
            // Mock OMDB to throw an exception (any exception should result in a 500)
            $this->mock(OmdbClient::class, function ($mock) {
                $mock->shouldReceive('search')
                    ->with('matrix', 1)
                    ->andThrow(new \Exception('API Error'));
            });

            // Search should fail with 500 error
            $response = $this->getJson('/api/movies/search?q=matrix');

            $response->assertStatus(500);
        });

        test('handles authentication token expiration', function () {
            $user = User::factory()->create();

            // Make request with invalid token
            $response = $this->withHeaders(['Authorization' => 'Bearer invalid-token'])
                ->getJson('/api/favorites');

            $response->assertStatus(401);
        });
    });
});
