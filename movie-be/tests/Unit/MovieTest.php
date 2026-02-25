<?php

use App\Models\Favorite;
use App\Models\Movie;

describe('Movie Model', function () {
    test('it can be created with factory', function () {
        $movie = Movie::factory()->create();

        expect($movie)->toBeInstanceOf(Movie::class)
            ->and($movie->imdb_id)->toBeString();
    });

    test('it can be created with specific imdb_id', function () {
        $imdbId = 'tt1234567';
        $movie = Movie::factory()->withImdbId($imdbId)->create();

        expect($movie->imdb_id)->toBe($imdbId);
    });

    test('it can be created with specific type', function () {
        $type = 'series';
        $movie = Movie::factory()->ofType($type)->create();

        expect($movie->type)->toBe($type);
    });

    test('it has fillable attributes', function () {
        $fillable = [
            'imdb_id',
            'title',
            'year',
            'type',
            'poster_url',
            'raw_payload',
        ];

        $movie = new Movie;

        expect($movie->getFillable())->toBe($fillable);
    });

    test('it casts raw_payload to array', function () {
        $movie = Movie::factory()->create();

        expect($movie->getCasts())->toMatchArray([
            'raw_payload' => 'array',
        ]);
    });

    test('it can have favorites relationship', function () {
        $movie = Movie::factory()->create();
        $favorites = Favorite::factory()->count(3)->forMovie($movie)->create();

        expect($movie->favorites->count())->toBe(3)
            ->and($movie->favorites->first())->toBeInstanceOf(Favorite::class);
    });

    test('it stores raw_payload as json in database', function () {
        $payload = [
            'Title' => 'Test Movie',
            'Year' => '2023',
            'Director' => 'Test Director',
        ];

        $movie = Movie::factory()->create(['raw_payload' => $payload]);

        // Refresh from database
        $movie->refresh();

        expect($movie->raw_payload)->toBe($payload);
    });
});
