<?php

use App\Models\Movie;
use App\Services\Omdb\OmdbClient;

describe('Movies API', function () {
    describe('GET /api/movies/search', function () {
        test('it can search movies from OMDB', function () {
            $mockOmdbResponse = [
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

            $this->mock(OmdbClient::class)
                ->shouldReceive('search')
                ->with('matrix', 1)
                ->andReturn($mockOmdbResponse);

            $response = $this->getJson('/api/movies/search?q=matrix');

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'imdb_id',
                        ],
                    ],
                    'meta' => [
                        'total',
                        'page',
                        'source',
                    ],
                ])
                ->assertJson([
                    'data' => [
                        [
                            'imdb_id' => 'tt0133093',
                        ],
                        [
                            'imdb_id' => 'tt0234215',
                        ],
                    ],
                    'meta' => [
                        'total' => 2,
                        'page' => 1,
                        'source' => 'omdb',
                    ],
                ]);
        });

        test('it requires query parameter', function () {
            $response = $this->getJson('/api/movies/search');

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['q']);
        });

        test('it validates minimum query length', function () {
            $response = $this->getJson('/api/movies/search?q=');

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['q']);
        });

        test('it accepts page parameter', function () {
            $mockOmdbResponse = [
                'Search' => [],
                'totalResults' => '0',
                'Response' => 'True',
            ];

            $this->mock(OmdbClient::class)
                ->shouldReceive('search')
                ->with('matrix', 2)
                ->andReturn($mockOmdbResponse);

            $response = $this->getJson('/api/movies/search?q=matrix&page=2');

            $response->assertStatus(200)
                ->assertJson([
                    'meta' => [
                        'page' => 2,
                    ],
                ]);
        });

        test('it validates page parameter is integer', function () {
            $response = $this->getJson('/api/movies/search?q=matrix&page=invalid');

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['page']);
        });

        test('it validates page parameter is minimum 1', function () {
            $response = $this->getJson('/api/movies/search?q=matrix&page=0');

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['page']);
        });

        test('it handles empty search results', function () {
            $mockOmdbResponse = [
                'Response' => 'False',
                'Error' => 'Movie not found!',
            ];

            $this->mock(OmdbClient::class)
                ->shouldReceive('search')
                ->with('nonexistentmovie', 1)
                ->andReturnUsing(fn () => $mockOmdbResponse);

            $response = $this->getJson('/api/movies/search?q=nonexistentmovie');

            $response->assertStatus(200)
                ->assertJson([
                    'data' => [],
                    'meta' => [
                        'total' => 0,
                        'page' => 1,
                        'source' => 'omdb',
                    ],
                ]);
        });
    });

    describe('GET /api/movies/{imdbId}', function () {
        test('it can show existing movie from database', function () {
            $movie = Movie::factory()->withImdbId('tt0133093')->create();

            $response = $this->getJson("/api/movies/{$movie->imdb_id}");

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'imdb_id',
                    ],
                ])
                ->assertJson([
                    'data' => [
                        'imdb_id' => $movie->imdb_id,
                    ],
                ]);
        });

        test('it fetches and stores new movie from OMDB', function () {
            $imdbId = 'tt0133093';
            $mockOmdbResponse = [
                'Title' => 'The Matrix',
                'Year' => '1999',
                'imdbID' => $imdbId,
                'Type' => 'movie',
                'Poster' => 'https://example.com/poster.jpg',
                'Plot' => 'A computer programmer is transported to a world...',
                'Director' => 'Lana Wachowski, Lilly Wachowski',
                'Response' => 'True',
            ];

            $this->mock(OmdbClient::class)
                ->shouldReceive('getByImdbId')
                ->with($imdbId)
                ->andReturnUsing(fn () => $mockOmdbResponse);

            $response = $this->getJson("/api/movies/{$imdbId}");

            $response
                ->assertJson([
                    'data' => [
                        'imdb_id' => $imdbId,
                    ],
                ]);

            // Verify movie was stored in database
            $this->assertDatabaseHas('movies', [
                'imdb_id' => $imdbId,
                'title' => 'The Matrix',
            ]);
        });
    });
});
