<?php

use App\Models\Favorite;
use App\Models\Movie;
use App\Models\User;

describe('Favorite Model', function () {
    test('it can be created with factory', function () {
        $favorite = Favorite::factory()->create();

        expect($favorite)->toBeInstanceOf(Favorite::class)
            ->and($favorite->user_id)->toBeInt()
            ->and($favorite->movie_id)->toBeInt()
            ->and($favorite->user)->toBeInstanceOf(User::class)
            ->and($favorite->movie)->toBeInstanceOf(Movie::class);
    });

    test('it can be created for specific user', function () {
        $user = User::factory()->create();
        $favorite = Favorite::factory()->forUser($user)->create();

        expect($favorite->user_id)->toBe($user->id)
            ->and($favorite->user->id)->toBe($user->id);
    });

    test('it can be created for specific movie', function () {
        $movie = Movie::factory()->create();
        $favorite = Favorite::factory()->forMovie($movie)->create();

        expect($favorite->movie_id)->toBe($movie->id)
            ->and($favorite->movie->id)->toBe($movie->id);
    });

    test('it has fillable attributes', function () {
        $fillable = ['user_id', 'movie_id'];

        $favorite = new Favorite;

        expect($favorite->getFillable())->toBe($fillable);
    });

    test('it belongs to a user', function () {
        $user = User::factory()->create();
        $favorite = Favorite::factory()->forUser($user)->create();

        expect($favorite->user)->toBeInstanceOf(User::class)
            ->and($favorite->user->id)->toBe($user->id);
    });

    test('it belongs to a movie', function () {
        $movie = Movie::factory()->create();
        $favorite = Favorite::factory()->forMovie($movie)->create();

        expect($favorite->movie)->toBeInstanceOf(Movie::class)
            ->and($favorite->movie->id)->toBe($movie->id);
    });

    test('it prevents duplicate favorites for same user and movie', function () {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        // Create first favorite
        $favorite1 = Favorite::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
        ]);

        // Attempt to create duplicate should throw exception
        expect(fn () => Favorite::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
        ]))->toThrow(Exception::class);
    });

    test('it has timestamps', function () {
        $favorite = Favorite::factory()->create();

        expect($favorite->created_at)->toBeInstanceOf(Carbon\Carbon::class)
            ->and($favorite->updated_at)->toBeInstanceOf(Carbon\Carbon::class);
    });
});
