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
        return Movie::where('imdb_id', $imdbId)->first();
    }

    public function getOrFetchByImdbId(string $imdbId): Movie
    {
        $existing = $this->findByImdbId($imdbId);

        if ($existing) {
            return $existing;
        }

        $payload = $this->omdbClient->getByImdbId($imdbId);

        return $this->storeFromOmdbPayload($payload);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    public function storeFromOmdbPayload(array $payload): Movie
    {
        return Movie::updateOrCreate(
            ['imdb_id' => $payload['imdbID'] ?? null],
            [
                'title' => $payload['Title'] ?? '',
                'year' => $payload['Year'] ?? null,
                'type' => $payload['Type'] ?? null,
                'poster_url' => $payload['Poster'] ?? null,
                'raw_payload' => $payload,
            ],
        );
    }
}
