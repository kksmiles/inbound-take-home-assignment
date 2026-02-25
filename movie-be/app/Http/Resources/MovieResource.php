<?php

namespace App\Http\Resources;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Movie
 */
class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'imdb_id' => $this->imdb_id,
            'title' => $this->title,
            'year' => $this->year,
            'type' => $this->type,
            'poster_url' => $this->poster_url,
            'is_favorited' => (bool) ($this->is_favorited ?? false),
            'details' => $this->raw_payload,
        ];
    }
}
