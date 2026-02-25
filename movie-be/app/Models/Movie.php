<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Movie extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'imdb_id',
        'title',
        'year',
        'type',
        'poster_url',
        'raw_payload',
        'loaded_details',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'raw_payload' => 'array',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function scopeWithIsFavorited(Builder $query): Builder
    {
        if (! Auth::guard('api')->check()) {
            return $query;
        }

        $userId = Auth::guard('api')->id();

        return $query->withExists([
            'favorites as is_favorited' => static function (Builder $favoriteQuery) use ($userId): void {
                $favoriteQuery->where('user_id', $userId);
            },
        ]);
    }
}
