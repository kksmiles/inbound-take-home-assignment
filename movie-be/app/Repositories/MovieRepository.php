<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Services\Omdb\OmdbClient;

class MovieRepository
{
    public function __construct(
        private readonly OmdbClient $omdbClient,
    ) {}

    public function findByImdbId(string $imdbId, bool $withIsFavorited): ?Movie
    {
        return Movie::when($withIsFavorited, static function ($query) {
            $query->withIsFavorited();
        })
            ->where('imdb_id', $imdbId)
            ->where('loaded_details', true)
            ->first();
    }

    public function getOrFetchByImdbId(string $imdbId, bool $withIsFavorited): ?Movie
    {
        $existing = $this->findByImdbId($imdbId, $withIsFavorited);

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
        $rows = [];
        foreach ($items as $item) {
            if (($item['imdbID'] ?? null) === null) {
                continue;
            }
            $rows[] = [
                'imdb_id' => $item['imdbID'] ?? null,
                'title' => $item['Title'] ?? '',
                'year' => $item['Year'] ?? null,
                'type' => $item['Type'] ?? null,
                'poster_url' => $item['Poster'] ?? null,
                'raw_payload' => json_encode($item),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Movie::upsert($rows, ['imdb_id'], ['title', 'year', 'type', 'poster_url', 'raw_payload', 'updated_at']);
    }

    public function getRecent(int $limit = 10)
    {
        return Movie::withIsFavorited()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
