<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
