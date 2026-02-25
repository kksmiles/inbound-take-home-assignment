<?php

use App\Models\Movie;
use App\Repositories\MovieRepository;
use App\Services\Omdb\OmdbClient;

describe('MovieRepository', function () {
    $omdbClient = null;
    $repository = null;

    beforeEach(function () use (&$omdbClient, &$repository) {
        $omdbClient = Mockery::mock(OmdbClient::class);
        $repository = new MovieRepository($omdbClient);
    });

    describe('findByImdbId method', function () use (&$omdbClient, &$repository) {
        test('it returns movie when found', function () use (&$repository) {
            $movie = Movie::factory()->withImdbId('tt0133093')->create();

            $result = $repository->findByImdbId('tt0133093');

            expect($result)->toBeInstanceOf(Movie::class)
                ->and($result->id)->toBe($movie->id)
                ->and($result->imdb_id)->toBe('tt0133093');
        });

        test('it returns null when movie not found', function () use (&$repository) {
            $result = $repository->findByImdbId('tt9999999');

            expect($result)->toBeNull();
        });
    });

    describe('getOrFetchByImdbId method', function () use (&$omdbClient, &$repository) {
        test('it returns existing movie from database', function () use (&$omdbClient, &$repository) {
            $existingMovie = Movie::factory()->withImdbId('tt0133093')->create();

            // Should not call OMDB client
            $omdbClient->shouldNotReceive('getByImdbId');

            $result = $repository->getOrFetchByImdbId('tt0133093');

            expect($result)->toBeInstanceOf(Movie::class)
                ->and($result->id)->toBe($existingMovie->id)
                ->and($result->imdb_id)->toBe('tt0133093');
        });

        test('it fetches and stores new movie from OMDB', function () use (&$omdbClient, &$repository) {
            $omdbPayload = [
                'Title' => 'The House Bunny',
                'Year' => '2008',
                'imdbID' => 'tt0852713',
                'Type' => 'movie',
                'Poster' => 'https://example.com/poster.jpg',
                'Plot' => 'Finding family. Shelley Darlingson was raised in an orphanage, finally happy when she blossoms into a fox and moves into the Playboy Mansion.',
                'Director' => 'Fred Wolf',
                'Response' => 'True',
            ];

            $omdbClient->shouldReceive('getByImdbId')
                ->with('tt0852713')
                ->once()
                ->andReturnUsing(fn () => $omdbPayload);

            $result = $repository->getOrFetchByImdbId('tt0852713');

            expect($result)->toBeInstanceOf(Movie::class)
                ->and($result->imdb_id)->toBe('tt0852713')
                ->and($result->title)->toBe('The House Bunny')
                ->and($result->year)->toBe('2008')
                ->and($result->type)->toBe('movie')
                ->and($result->poster_url)->toBe('https://example.com/poster.jpg')
                ->and($result->raw_payload)->toBe($omdbPayload);

            // Verify movie was stored in database
            $this->assertDatabaseHas('movies', [
                'imdb_id' => 'tt0852713',
                'title' => 'The House Bunny',
            ]);
        });
    });

    describe('storeFromOmdbPayload method', function () use (&$repository) {
        test('it creates new movie from OMDB payload', function () use (&$repository) {
            $payload = [
                'Title' => 'The Matrix',
                'Year' => '1999',
                'imdbID' => 'tt0133093',
                'Type' => 'movie',
                'Poster' => 'https://example.com/poster.jpg',
                'Plot' => 'A computer programmer is transported to a simulated reality.',
            ];

            $result = $repository->storeFromOmdbPayload($payload);

            expect($result)->toBeInstanceOf(Movie::class)
                ->and($result->imdb_id)->toBe('tt0133093')
                ->and($result->title)->toBe('The Matrix')
                ->and($result->year)->toBe('1999')
                ->and($result->type)->toBe('movie')
                ->and($result->poster_url)->toBe('https://example.com/poster.jpg')
                ->and($result->raw_payload)->toBe($payload);
        });

        test('it updates existing movie from OMDB payload', function () use (&$repository) {
            $existingMovie = Movie::factory()->create([
                'imdb_id' => 'tt0133093',
                'title' => 'Old Title',
                'year' => '1998',
            ]);

            $payload = [
                'Title' => 'The Matrix',
                'Year' => '1999',
                'imdbID' => 'tt0133093',
                'Type' => 'movie',
                'Poster' => 'https://example.com/poster.jpg',
            ];

            $result = $repository->storeFromOmdbPayload($payload);

            expect($result)->toBeInstanceOf(Movie::class)
                ->and($result->id)->toBe($existingMovie->id) // Same database record
                ->and($result->imdb_id)->toBe('tt0133093')
                ->and($result->title)->toBe('The Matrix') // Updated
                ->and($result->year)->toBe('1999'); // Updated
        });

        test('it handles missing payload fields gracefully', function () use (&$repository) {
            $payload = [
                'imdbID' => 'tt0133093',
                // Missing other fields
            ];

            $result = $repository->storeFromOmdbPayload($payload);

            expect($result)->toBeInstanceOf(Movie::class)
                ->and($result->imdb_id)->toBe('tt0133093')
                ->and($result->title)->toBe('') // Default empty string
                ->and($result->year)->toBeNull()
                ->and($result->type)->toBeNull()
                ->and($result->poster_url)->toBeNull()
                ->and($result->raw_payload)->toBe($payload);
        });
    });
});
