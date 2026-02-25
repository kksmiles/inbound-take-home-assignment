<?php

use App\Models\Favorite;
use App\Models\User;

describe('User Model', function () {
    test('it can be created with factory', function () {
        $user = User::factory()->create();

        expect($user)->toBeInstanceOf(User::class)
            ->and($user->name)->toBeString()
            ->and($user->email)->toBeString()
            ->and($user->email_verified_at)->toBeInstanceOf(DateTime::class);
    });

    test('it can be created as unverified', function () {
        $user = User::factory()->unverified()->create();

        expect($user->email_verified_at)->toBeNull()
            ->and($user->hasVerifiedEmail())->toBeFalse();
    });

    test('it hashes password on creation', function () {
        $user = User::factory()->create(['password' => 'password123']);

        expect($user->password)->not->toBe('password123')
            ->and(Hash::check('password123', $user->password))->toBeTrue();
    });

    test('it has fillable attributes', function () {
        $fillable = ['name', 'email', 'password'];

        $user = new User;

        expect($user->getFillable())->toBe($fillable);
    });

    test('it has hidden attributes', function () {
        $hidden = ['password', 'remember_token'];

        $user = new User;

        expect($user->getHidden())->toBe($hidden);
    });

    test('it casts attributes properly', function () {
        $user = User::factory()->create();

        expect($user->getCasts())->toMatchArray([
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ]);
    });

    test('it can have favorites relationship', function () {
        $user = User::factory()->create();
        $favorites = Favorite::factory()->count(3)->forUser($user)->create();

        expect($user->favorites->count())->toBe(3)
            ->and($user->favorites->first())->toBeInstanceOf(Favorite::class);
    });
});
