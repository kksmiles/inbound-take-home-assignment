<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct(
        private readonly MovieRepository $movies,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $perPage = (int) $request->query('per_page', 10);

        $favorites = Favorite::query()
            ->where('user_id', $userId)
            ->with([
                'movie' => static function ($query) {
                    $query->withIsFavorited();
                },
            ])
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return FavoriteResource::collection($favorites)
            ->toResponse($request);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'imdb_id' => ['required', 'string'],
        ]);

        $movie = Movie::where('imdb_id', $validated['imdb_id'])->first();
        if (! $movie) {
            return response()->json([
                'message' => 'Movie not found.',
            ], 404);
        }

        /** @var \App\Models\User $user */
        $user = $request->user();

        /*
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email verification required to manage favorites.',
            ], 403);
        }
        */

        Favorite::firstOrCreate([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Favorite added.',
        ], 201);
    }

    public function destroy(Request $request, string $imdbId): JsonResponse
    {
        $movie = Movie::where('imdb_id', $imdbId)->first();
        if (! $movie) {
            return response()->json([
                'message' => 'Movie not found.',
            ], 404);
        }

        /** @var \App\Models\User $user */
        $user = $request->user();

        Favorite::query()
            ->where('user_id', $user->id)
            ->where('movie_id', $movie->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Favorite removed.',
        ]);
    }
}
