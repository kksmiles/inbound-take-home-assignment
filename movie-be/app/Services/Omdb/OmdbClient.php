<?php

namespace App\Services\Omdb;

use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\RequestException;

class OmdbClient
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {}

    /**
     * @return array<string, mixed>
     *
     * @throws RequestException
     */
    public function search(string $query, int $page = 1): array
    {
        $response = $this->http
            ->baseUrl(config('thirdpartyapi.omdb.base_url'))
            ->get('', [
                'apikey' => config('thirdpartyapi.omdb.api_key'),
                's' => $query,
                'page' => $page,
            ])
            ->throw();

        return $response->json();
    }

    /**
     * @return array<string, mixed>
     *
     * @throws RequestException
     */
    public function getByImdbId(string $imdbId): array
    {
        $response = $this->http
            ->baseUrl(config('thirdpartyapi.omdb.base_url'))
            ->get('', [
                'apikey' => config('thirdpartyapi.omdb.api_key'),
                'i' => $imdbId,
                'plot' => 'full',
            ])
            ->throw();

        return $response->json();
    }
}
