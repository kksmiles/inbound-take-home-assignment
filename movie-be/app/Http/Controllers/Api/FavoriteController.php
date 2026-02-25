<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
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
        $favorites = Favorite::query()
            ->where('user_id', $request->user()->id)
            ->with('movie')
            ->orderByDesc('created_at')
            ->get();

        return FavoriteResource::collection($favorites)
            ->toResponse($request);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'imdb_id' => ['required', 'string'],
        ]);

        $movie = $this->movies->getOrFetchByImdbId($validated['imdb_id']);
        if (! $movie) {
            return response()->json([
                'message' => 'Movie not found.',
            ], 404);
        }

        /** @var \App\Models\User $user */
        $user = $request->user();

        if (! $user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email verification required to manage favorites.',
            ], 403);
        }

        $favorite = Favorite::firstOrCreate([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
        ]);

        return FavoriteResource::make($favorite->load('movie'))
            ->response()
            ->setStatusCode(201);
    }

    public function destroy(Request $request, string $imdbId): JsonResponse
    {
        $movie = $this->movies->getOrFetchByImdbId($imdbId);

        if (! $movie) {
            return response()->json([
                'message' => 'Favorite not found.',
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
