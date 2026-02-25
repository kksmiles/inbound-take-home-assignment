<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Services\Omdb\OmdbClient;

class MovieRepository
{
    public function __construct(
        private readonly OmdbClient $omdbClient,
    ) {}

    public function findByImdbId(string $imdbId): ?Movie
    {
        return Movie::where('imdb_id', $imdbId)->where('loaded_details', true)->first();
    }

    public function getOrFetchByImdbId(string $imdbId): ?Movie
    {
        $existing = $this->findByImdbId($imdbId);

        if ($existing) {
            return $existing;
        }

        $payload = $this->omdbClient->getByImdbId($imdbId);

        if (($payload['imdbID'] ?? null) === null) {
            return null;
        }

        return $this->storeFromOmdbPayload($payload, true);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function storeFromOmdbPayload(array $payload, bool $loaded_details = false): Movie
    {
        return Movie::updateOrCreate(
            ['imdb_id' => $payload['imdbID'] ?? null],
            [
                'title' => $payload['Title'] ?? '',
                'year' => $payload['Year'] ?? null,
                'type' => $payload['Type'] ?? null,
                'poster_url' => $payload['Poster'] ?? null,
                'raw_payload' => $payload,
                'loaded_details' => $loaded_details,
            ],
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     */
    public function storeSearchResults(array $items): void
    {
        foreach ($items as $payload) {
            $this->storeFromOmdbPayload($payload, false);
        }
    }

    public function getRecent(int $limit = 10)
    {
        return Movie::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
