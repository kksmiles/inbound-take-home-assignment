<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
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

        $movies = collect($searchItems)->map(function (array $item): array {
            return [
                'imdb_id' => $item['imdbID'] ?? null,
                'title' => $item['Title'] ?? null,
                'year' => $item['Year'] ?? null,
                'type' => $item['Type'] ?? null,
                'poster_url' => $item['Poster'] ?? null,
            ];
        });

        return response()->json([
            'data' => $movies,
            'meta' => [
                'total' => isset($results['totalResults']) ? (int) $results['totalResults'] : $movies->count(),
                'page' => $page,
                'per_page' => $movies->count(),
                'source' => 'omdb',
            ],
        ]);
    }

    public function show(string $imdbId): JsonResponse
    {
        $movie = $this->movies->getOrFetchByImdbId($imdbId);
        if (! $movie) {
            return response()->json([
                'message' => 'Movie not found.',
            ], 404);
        }

        return MovieResource::make($movie)
            ->toResponse(request());
    }
}
