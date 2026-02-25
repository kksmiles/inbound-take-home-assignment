<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Repositories\MovieRepository;
use App\Services\Omdb\OmdbClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Movies
 *
 * Endpoints for searching and retrieving movies.
 */
class MovieController extends Controller
{
    public function __construct(
        private readonly OmdbClient $omdbClient,
        private readonly MovieRepository $movies,
    ) {}

    /**
     * List recent movies
     *
     * Returns a list of the most recently stored movies.
     */
    public function index(Request $request): JsonResponse
    {
        $movies = $this->movies->getRecent(10);

        return MovieResource::collection($movies)
            ->toResponse($request);
    }

    /**
     * Search movies
     *
     * Search for movies using the OMDb API and return matched titles.
     *
     * @queryParam q string required The search term (title or keyword). Example: The Matrix
     * @queryParam page integer The page of results to view. Minimum: 1. Example: 2
     */
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
        $movies = $this->movies->findManyByImdbIds($imdbIds);

        return response()->json([
            'data' => MovieResource::collection($movies),
            'meta' => [
                'total' => isset($results['totalResults']) ? (int) $results['totalResults'] : $movies->count(),
                'current_page' => $page,
                'per_page' => $movies->count(),
                'source' => 'omdb',
                'omdb_response' => $results['Response'] ?? null,
                'omdb_error' => $results['Error'] ?? null,
            ],
        ]);
    }

    /**
     * Show movie details
     *
     * Retrieve full details for a movie by its IMDb ID.
     *
     * @urlParam imdbId string required The IMDb ID of the movie. Example: tt0133093
     */
    public function show(Request $request, string $imdbId): JsonResponse
    {
        $movie = $this->movies->getOrFetchByImdbId($imdbId, true);
        if (! $movie) {
            return response()->json([
                'message' => 'Movie not found.',
            ], 404);
        }

        return MovieResource::make($movie)
            ->toResponse($request);
    }
}
