<?php

use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/health_check', function () {
    return response()->json(['status' => 'ok']);
});

Route::get('movies/search', [MovieController::class, 'search']);
Route::get('movies/{imdbId}', [MovieController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    Route::get('favorites', [FavoriteController::class, 'index']);
    Route::post('favorites', [FavoriteController::class, 'store']);
    Route::delete('favorites/{imdbId}', [FavoriteController::class, 'destroy']);
});
