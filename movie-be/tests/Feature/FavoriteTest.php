<?php

use App\Models\Favorite;
use App\Models\Movie;
use App\Models\User;
use App\Services\Omdb\OmdbClient;

describe('Favorites API', function () {
    describe('GET /api/favorites', function () {
        test('it returns user favorites', function () {
            $user = User::factory()->create();
            $movies = Movie::factory()->count(3)->create();

            foreach ($movies as $movie) {
                Favorite::factory()->create([
                    'user_id' => $user->id,
                    'movie_id' => $movie->id,
                ]);
            }

            $response = $this->actingAs($user, 'api')
                ->getJson('/api/favorites');

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'movie' => [
                                'imdb_id',
                            ],
                            'created_at',
                        ],
                    ],
                ])
                ->assertJsonCount(3, 'data');
        });

        test('it returns empty array for user with no favorites', function () {
            $user = User::factory()->create();

            $response = $this->actingAs($user, 'api')
                ->getJson('/api/favorites');

            $response->assertStatus(200)
                ->assertJson([
                    'data' => [],
                ]);
        });

        test('it requires authentication', function () {
            $response = $this->getJson('/api/favorites');

            $response->assertStatus(401);
        });

        test('it orders favorites by creation date descending', function () {
            $user = User::factory()->create();
            $movie1 = Movie::factory()->create();
            $movie2 = Movie::factory()->create();

            // Create favorites with specific timestamps
            $favorite1 = Favorite::factory()->create([
                'user_id' => $user->id,
                'movie_id' => $movie1->id,
                'created_at' => now()->subHour(),
            ]);

            $favorite2 = Favorite::factory()->create([
                'user_id' => $user->id,
                'movie_id' => $movie2->id,
                'created_at' => now(),
            ]);

            $response = $this->actingAs($user, 'api')
                ->getJson('/api/favorites');

            $response->assertStatus(200);

            $favorites = $response->json('data');
            expect($favorites[0]['id'])->toBe($favorite2->id) // Most recent first
                ->and($favorites[1]['id'])->toBe($favorite1->id);
        });
    });

    describe('POST /api/favorites', function () {
        test('it can add existing movie to favorites', function () {
            $user = User::factory()->create();
            $movie = Movie::factory()->withImdbId('tt0133093')->create();

            $response = $this->actingAs($user, 'api')
                ->postJson('/api/favorites', [
                    'imdb_id' => $movie->imdb_id,
                ]);

            $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'movie' => [
                            'imdb_id',
                        ],
                        'created_at',
                    ],
                ]);

            $this->assertDatabaseHas('favorites', [
                'user_id' => $user->id,
                'movie_id' => $movie->id,
            ]);
        });

        test('it can add new movie from OMDB to favorites', function () {
            $user = User::factory()->create();
            $imdbId = 'tt0133093';

            $mockOmdbResponse = [
                'Title' => 'The Matrix',
                'Year' => '1999',
                'imdbID' => $imdbId,
                'Type' => 'movie',
                'Poster' => 'https://example.com/poster.jpg',
                'Plot' => 'A computer programmer is transported to a world...',
                'Response' => 'True',
            ];

            $this->mock(OmdbClient::class)
                ->shouldReceive('getByImdbId')
                ->with($imdbId)
                ->andReturnUsing(fn () => $mockOmdbResponse);

            $response = $this->actingAs($user, 'api')
                ->postJson('/api/favorites', [
                    'imdb_id' => $imdbId,
                ]);

            $response->assertStatus(201);

            // Verify movie was created and favorited
            $this->assertDatabaseHas('movies', [
                'imdb_id' => $imdbId,
                'title' => 'The Matrix',
            ]);

            $movie = Movie::where('imdb_id', $imdbId)->first();
            $this->assertDatabaseHas('favorites', [
                'user_id' => $user->id,
                'movie_id' => $movie->id,
            ]);
        });

        test('it prevents duplicate favorites', function () {
            $user = User::factory()->create();
            $movie = Movie::factory()->create();

            // Create existing favorite
            Favorite::factory()->create([
                'user_id' => $user->id,
                'movie_id' => $movie->id,
            ]);

            $response = $this->actingAs($user, 'api')
                ->postJson('/api/favorites', [
                    'imdb_id' => $movie->imdb_id,
                ]);

            // Should still return 201 due to firstOrCreate
            $response->assertStatus(201);

            // Should only have one favorite in database
            expect(Favorite::where('user_id', $user->id)
                ->where('movie_id', $movie->id)
                ->count())->toBe(1);
        });

        test('it requires email verification to add favorites', function () {
            $user = User::factory()->unverified()->create();
            $movie = Movie::factory()->create();

            $response = $this->actingAs($user, 'api')
                ->postJson('/api/favorites', [
                    'imdb_id' => $movie->imdb_id,
                ]);

            $response->assertStatus(403)
                ->assertJson([
                    'message' => 'Email verification required to manage favorites.',
                ]);
        });

        test('it requires authentication', function () {
            $response = $this->postJson('/api/favorites', [
                'imdb_id' => 'tt0133093',
            ]);

            $response->assertStatus(401);
        });

        test('it validates required imdb_id', function () {
            $user = User::factory()->create();

            $response = $this->actingAs($user, 'api')
                ->postJson('/api/favorites', []);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['imdb_id']);
        });
    });

    describe('DELETE /api/favorites/{imdbId}', function () {
        test('it can remove movie from favorites', function () {
            $user = User::factory()->create();
            $movie = Movie::factory()->create();
            $favorite = Favorite::factory()->create([
                'user_id' => $user->id,
                'movie_id' => $movie->id,
            ]);

            $response = $this->actingAs($user, 'api')
                ->deleteJson("/api/favorites/{$movie->imdb_id}");

            $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Favorite removed.',
                ]);

            $this->assertDatabaseMissing('favorites', [
                'id' => $favorite->id,
            ]);
        });

        test('it returns 404 when movie not found', function () {
            $user = User::factory()->create();

            $response = $this->actingAs($user, 'api')
                ->deleteJson('/api/favorites/tt9999999');

            $response->assertStatus(404)
                ->assertJson([
                    'message' => 'Favorite not found.',
                ]);
        });

        test('it handles removing non-favorited movie gracefully', function () {
            $user = User::factory()->create();
            $movie = Movie::factory()->create();
            // Movie exists but not favorited by user

            $response = $this->actingAs($user, 'api')
                ->deleteJson("/api/favorites/{$movie->imdb_id}");

            $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Favorite removed.',
                ]);
        });

        test('it requires authentication', function () {
            $response = $this->deleteJson('/api/favorites/tt0133093');

            $response->assertStatus(401);
        });

        test('it only removes current user favorites', function () {
            $user1 = User::factory()->create();
            $user2 = User::factory()->create();
            $movie = Movie::factory()->create();

            // Both users favorite the same movie
            $favorite1 = Favorite::factory()->create([
                'user_id' => $user1->id,
                'movie_id' => $movie->id,
            ]);
            $favorite2 = Favorite::factory()->create([
                'user_id' => $user2->id,
                'movie_id' => $movie->id,
            ]);

            // User1 removes favorite
            $response = $this->actingAs($user1, 'api')
                ->deleteJson("/api/favorites/{$movie->imdb_id}");

            $response->assertStatus(200);

            // User1's favorite should be removed
            $this->assertDatabaseMissing('favorites', [
                'id' => $favorite1->id,
            ]);

            // User2's favorite should remain
            $this->assertDatabaseHas('favorites', [
                'id' => $favorite2->id,
            ]);
        });
    });
});
