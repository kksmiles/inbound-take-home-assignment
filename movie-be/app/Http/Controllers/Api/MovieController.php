<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use App\Services\Omdb\OmdbClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(
        private readonly OmdbClient $omdbClient,
        private readonly MovieRepository $movies,
    ) {}

    public function index()
    {
        $movies = $this->movies->getRecent(10);

        return MovieResource::collection($movies)
            ->toResponse(request());
    }

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'min:1'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ]);

        $page = (int) ($validated['page'] ?? 1);

        $results = $this->omdbClient->search($validated['q'], $page);
        $searchItems = $results['Search'] ?? [];

        // Store/refresh search results in the local database for later use
        if (is_array($searchItems) && $searchItems !== []) {
            $this->movies->storeSearchResults($searchItems);
        }

        $imdbIds = collect($searchItems)->pluck('imdbID')->toArray();
        $movies = Movie::withIsFavorited()->whereIn('imdb_id', $imdbIds)->get();

        return response()->json([
            'data' => MovieResource::collection($movies),
            'meta' => [
                'total' => isset($results['totalResults']) ? (int) $results['totalResults'] : $movies->count(),
                'current_page' => $page,
                'per_page' => $movies->count(),
                'source' => 'omdb',
            ],
        ]);
    }

    public function show(string $imdbId): JsonResponse
    {
        $movie = $this->movies->getOrFetchByImdbId($imdbId, true);
        if (! $movie) {
            return response()->json([
                'message' => 'Movie not found.',
            ], 404);
        }
        $movie = Movie::withIsFavorited()->where('id', $movie->id)->first();

        return MovieResource::make($movie)
            ->toResponse(request());
    }
}
