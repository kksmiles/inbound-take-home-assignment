<?php

namespace Tests\Helpers;

use App\Models\User;
use App\Services\Omdb\OmdbClient;

class TestHelper
{
    /**
     * Create a verified user for testing
     */
    public static function createVerifiedUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    /**
     * Create an unverified user for testing
     */
    public static function createUnverifiedUser(array $attributes = []): User
    {
        return User::factory()->unverified()->create($attributes);
    }

    /**
     * Mock OMDB client to return search results
     */
    public static function mockOmdbSearch(array $searchResults = [], string $query = 'matrix', int $page = 1): void
    {
        $mockResponse = [
            'Search' => $searchResults,
            'totalResults' => (string) count($searchResults),
            'Response' => 'True',
        ];

        app()->bind(OmdbClient::class, function () use ($mockResponse, $query, $page) {
            $mock = \Mockery::mock(OmdbClient::class);
            $mock->shouldReceive('search')
                ->with($query, $page)
                ->andReturn($mockResponse);

            return $mock;
        });
    }

    /**
     * Mock OMDB client to return movie details
     */
    public static function mockOmdbGetByImdbId(array $movieDetails, string $imdbId): void
    {
        app()->bind(OmdbClient::class, function () use ($movieDetails, $imdbId) {
            $mock = \Mockery::mock(OmdbClient::class);
            $mock->shouldReceive('getByImdbId')
                ->with($imdbId)
                ->andReturn($movieDetails);

            return $mock;
        });
    }

    /**
     * Mock OMDB client to throw an exception
     */
    public static function mockOmdbError(string $method = 'search', string $errorMessage = 'API Error'): void
    {
        app()->bind(OmdbClient::class, function () use ($method, $errorMessage) {
            $mock = \Mockery::mock(OmdbClient::class);
            $mock->shouldReceive($method)
                ->andThrow(new \Exception($errorMessage));

            return $mock;
        });
    }

    /**
     * Get default movie data for testing
     */
    public static function getDefaultMovieData(string $imdbId = 'tt0133093'): array
    {
        return [
            'Title' => 'The Matrix',
            'Year' => '1999',
            'imdbID' => $imdbId,
            'Type' => 'movie',
            'Poster' => 'https://example.com/poster.jpg',
            'Plot' => 'A computer programmer is transported to a simulated reality.',
            'Director' => 'Lana Wachowski, Lilly Wachowski',
            'Writer' => 'Lana Wachowski, Lilly Wachowski',
            'Actors' => 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss',
            'Genre' => 'Action, Sci-Fi',
            'Runtime' => '136 min',
            'imdbRating' => '8.7',
            'Response' => 'True',
        ];
    }

    /**
     * Get default search results for testing
     */
    public static function getDefaultSearchResults(): array
    {
        return [
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
        ];
    }

    /**
     * Assert JSON structure for movie data
     */
    public static function getMovieJsonStructure(): array
    {
        return [
            'imdb_id',
            'title',
            'year',
            'type',
            'poster_url',
            'details',
        ];
    }

    /**
     * Assert JSON structure for user data
     */
    public static function getUserJsonStructure(): array
    {
        return [
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Assert JSON structure for favorite data
     */
    public static function getFavoriteJsonStructure(): array
    {
        return [
            'id',
            'user_id',
            'movie' => self::getMovieJsonStructure(),
            'created_at',
            'updated_at',
        ];
    }
}
