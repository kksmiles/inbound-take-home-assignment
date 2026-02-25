<?php

use App\Services\Omdb\OmdbClient;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

describe('OmdbClient Service', function () {
    beforeEach(function () {
        config([
            'thirdpartyapi.omdb.base_url' => 'https://www.omdbapi.com/',
            'thirdpartyapi.omdb.api_key' => 'test-api-key',
        ]);
    });

    describe('search method', function () {
        test('it can search movies successfully', function () {
            $mockResponse = [
                'Search' => [
                    [
                        'Title' => 'The Matrix',
                        'Year' => '1999',
                        'imdbID' => 'tt0133093',
                        'Type' => 'movie',
                        'Poster' => 'https://example.com/poster.jpg',
                    ],
                ],
                'totalResults' => '1',
                'Response' => 'True',
            ];

            Http::fake([
                'https://www.omdbapi.com/*' => Http::response($mockResponse, 200),
            ]);

            $client = app(OmdbClient::class);
            $result = $client->search('matrix');

            expect($result)->toBe($mockResponse);

            Http::assertSent(
                fn ($request) => $request['apikey'] === 'test-api-key'
                && $request['s'] === 'matrix'
                && $request['page'] === 1
            );
        });

        test('it can search with custom page number', function () {
            Http::fake([
                '*' => Http::response([
                    'Search' => [],
                    'totalResults' => '0',
                    'Response' => 'True',
                ], 200),
            ]);

            $client = app(OmdbClient::class);
            $client->search('matrix', 2);

            Http::assertSent(
                fn ($request) => $request['page'] === 2
            );
        });

        test('it throws exception on HTTP error', function () {
            Http::fake([
                '*' => Http::response([], 500),
            ]);

            $client = app(OmdbClient::class);

            expect(fn () => $client->search('matrix'))
                ->toThrow(RequestException::class);
        });
    });

    describe('getByImdbId method', function () {
        test('it can get movie by IMDB ID successfully', function () {
            $mockResponse = [
                'Title' => 'The Matrix',
                'Year' => '1999',
                'imdbID' => 'tt0133093',
                'Type' => 'movie',
                'Plot' => 'A computer programmer is transported to a simulated reality.',
                'Director' => 'Lana Wachowski, Lilly Wachowski',
                'Response' => 'True',
            ];

            Http::fake([
                '*' => Http::response($mockResponse, 200),
            ]);

            $client = app(OmdbClient::class);
            $result = $client->getByImdbId('tt0133093');

            expect($result)->toBe($mockResponse);

            Http::assertSent(
                fn ($request) => $request['i'] === 'tt0133093'
                && $request['plot'] === 'full'
            );
        });

        test('it throws exception on HTTP error', function () {
            Http::fake([
                '*' => Http::response([], 404),
            ]);

            $client = app(OmdbClient::class);

            expect(fn () => $client->getByImdbId('tt0133093'))
                ->toThrow(RequestException::class);
        });
    });
});
