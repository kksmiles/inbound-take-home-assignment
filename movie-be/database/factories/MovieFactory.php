<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'imdb_id' => 'tt'.fake()->unique()->numberBetween(1000000, 9999999),
            'title' => fake()->sentence(3),
            'year' => fake()->year(),
            'type' => fake()->randomElement(['movie', 'series', 'episode']),
            'poster_url' => fake()->imageUrl(300, 450, 'movies'),
            'raw_payload' => [
                'Title' => fake()->sentence(3),
                'Year' => fake()->year(),
                'imdbID' => 'tt'.fake()->numberBetween(1000000, 9999999),
                'Type' => fake()->randomElement(['movie', 'series', 'episode']),
                'Poster' => fake()->imageUrl(300, 450, 'movies'),
                'Plot' => fake()->paragraph(),
                'Director' => fake()->name(),
                'Writer' => fake()->name(),
                'Actors' => fake()->name().', '.fake()->name().', '.fake()->name(),
                'Genre' => fake()->randomElement(['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi']),
                'Runtime' => fake()->numberBetween(80, 180).' min',
                'imdbRating' => fake()->randomFloat(1, 1.0, 10.0),
            ],
        ];
    }

    /**
     * Create a movie with specific IMDB ID
     */
    public function withImdbId(string $imdbId): static
    {
        return $this->state(function (array $attributes) use ($imdbId) {
            $payload = $attributes['raw_payload'];
            $payload['imdbID'] = $imdbId;

            return [
                'imdb_id' => $imdbId,
                'raw_payload' => $payload,
            ];
        });
    }

    /**
     * Create a movie of specific type
     */
    public function ofType(string $type): static
    {
        return $this->state(function (array $attributes) use ($type) {
            $payload = $attributes['raw_payload'];
            $payload['Type'] = $type;

            return [
                'type' => $type,
                'raw_payload' => $payload,
            ];
        });
    }
}
