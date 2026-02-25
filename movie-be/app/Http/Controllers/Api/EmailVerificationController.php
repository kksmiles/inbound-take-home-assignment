<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Email verification
 *
 * Endpoints for sending and handling email verification links.
 */
class EmailVerificationController extends Controller
{
    /**
     * Send verification email
     *
     * Send an email verification link to the authenticated user.
     *
     * @authenticated
     */
    public function send(Request $request): JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified.',
            ], 200);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification link sent.',
        ], 202);
    }

    /**
     * Verify email address
     *
     * Mark a user's email address as verified using the link parameters.
     *
     * @urlParam id integer required The ID of the user whose email is being verified. Example: 1
     * @urlParam hash string required The verification hash from the email link.
     */
    public function verify(Request $request, int $id, string $hash): JsonResponse
    {
        /** @var User|null $user */
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            return response()->json([
                'message' => 'Invalid verification link.',
            ], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return UserResource::make($user)->toResponse($request);
        }

        $user->markEmailAsVerified();

        event(new Verified($user));

        return UserResource::make($user)->toResponse($request);
    }
}
