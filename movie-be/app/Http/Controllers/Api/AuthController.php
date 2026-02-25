<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @group Auth
 *
 * Endpoints for registering, logging in and managing the authenticated user.
 */
class AuthController extends Controller
{
    /**
     * Register a new user
     *
     * Create a new user account and return the created user.
     *
     * @unauthenticated
     *
     * @bodyParam name string required The name of the user. Example: Jane Doe
     * @bodyParam email string required The email address of the user. Must be unique. Example: jane@example.com
     * @bodyParam password string required The password for the account (min 8 characters). Example: password123
     * @bodyParam password_confirmation string required Must match the password field. Example: password123
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /** @var User $user */
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Log in
     *
     * Authenticate an existing user and return an access token.
     *
     * @unauthenticated
     *
     * @bodyParam email string required The email address of the user. Example: jane@example.com
     * @bodyParam password string required The user password. Example: password123
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        $token = $user->createToken('movie-api')->accessToken;
        $expiredAt = now()->addSeconds(config('passport.token_expiration'))->toDateTimeString();

        return response()->json([
            'data' => [
                'user' => UserResource::make($user),
                'token' => $token,
                'expires_at' => $expiredAt,
            ],
        ]);
    }

    /**
     * Get the authenticated user
     *
     * Return the currently authenticated user's details.
     *
     * @authenticated
     */
    public function me(Request $request): JsonResponse
    {
        return UserResource::make($request->user())
            ->toResponse($request);
    }

    /**
     * Log out
     *
     * Revoke the current access token and log the user out.
     *
     * @authenticated
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var \Laravel\Passport\Token|null $token */
        $token = $request->user()?->token();

        if ($token) {
            $token->revoke();
        }

        return response()->json([
            'message' => 'Logged out',
        ]);
    }
}
