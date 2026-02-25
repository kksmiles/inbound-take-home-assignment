<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

describe('Authentication API', function () {
    describe('POST /api/auth/register', function () {
        test('it can register a new user', function () {
            $userData = [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->postJson('/api/auth/register', $userData);

            $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ]);

            $this->assertDatabaseHas('users', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ]);
        });

        test('it validates required fields on registration', function () {
            $response = $this->postJson('/api/auth/register', []);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['name', 'email', 'password']);
        });

        test('it validates email format', function () {
            $userData = [
                'name' => 'John Doe',
                'email' => 'invalid-email',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->postJson('/api/auth/register', $userData);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });

        test('it validates unique email', function () {
            User::factory()->create(['email' => 'existing@example.com']);

            $userData = [
                'name' => 'John Doe',
                'email' => 'existing@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];

            $response = $this->postJson('/api/auth/register', $userData);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });

        test('it validates password confirmation', function () {
            $userData = [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'password123',
                'password_confirmation' => 'different_password',
            ];

            $response = $this->postJson('/api/auth/register', $userData);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['password']);
        });

        test('it validates minimum password length', function () {
            $userData = [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => '123',
                'password_confirmation' => '123',
            ];

            $response = $this->postJson('/api/auth/register', $userData);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['password']);
        });
    });

    describe('POST /api/auth/login', function () {
        test('it can login with valid credentials', function () {
            $user = User::factory()->create([
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
            ]);

            $response = $this->postJson('/api/auth/login', [
                'email' => 'john@example.com',
                'password' => 'password123',
            ]);

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'user' => [
                            'id',
                            'name',
                            'email',
                        ],
                        'token',
                        'expires_at',
                    ],
                ]);

            expect($response->json('data.user.id'))->toBe($user->id);
        });

        test('it fails login with invalid credentials', function () {
            User::factory()->create([
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
            ]);

            $response = $this->postJson('/api/auth/login', [
                'email' => 'john@example.com',
                'password' => 'wrong_password',
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });

        test('it validates required fields on login', function () {
            $response = $this->postJson('/api/auth/login', []);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email', 'password']);
        });

        test('it validates email format on login', function () {
            $response = $this->postJson('/api/auth/login', [
                'email' => 'invalid-email',
                'password' => 'password123',
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });
    });

    describe('GET /api/auth/me', function () {
        test('it returns authenticated user profile', function () {
            $user = User::factory()->create();

            $response = $this->actingAs($user, 'api')
                ->getJson('/api/auth/me');

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ])
                ->assertJson([
                    'data' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                ]);
        });

        test('it requires authentication', function () {
            $response = $this->getJson('/api/auth/me');

            $response->assertStatus(401);
        });
    });

    describe('POST /api/auth/logout', function () {
        test('it can logout authenticated user', function () {
            $user = User::factory()->create();

            $response = $this->actingAs($user, 'api')
                ->postJson('/api/auth/logout');

            $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Logged out',
                ]);
        });

        test('it requires authentication', function () {
            $response = $this->postJson('/api/auth/logout');

            $response->assertStatus(401);
        });
    });
});
