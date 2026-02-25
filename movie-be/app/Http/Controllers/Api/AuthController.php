<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
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

    public function me(Request $request): JsonResponse
    {
        return UserResource::make($request->user())
            ->toResponse($request);
    }

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
