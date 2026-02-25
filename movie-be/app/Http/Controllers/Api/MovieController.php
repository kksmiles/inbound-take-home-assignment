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

    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'q' => ['required', 'string', 'min:1'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ]);

        $page = (int) ($validated['page'] ?? 1);

        $results = $this->omdbClient->search($validated['q'], $page);

        $movies = collect($results['Search'] ?? [])->map(function (array $item): array {
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
                'source' => 'omdb',
            ],
        ]);
    }

    public function show(string $imdbId): JsonResponse
    {
        $movie = $this->movies->getOrFetchByImdbId($imdbId);

        return MovieResource::make($movie)
            ->toResponse(request());
    }
}
