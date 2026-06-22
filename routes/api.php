<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedisRateLimiter;
use App\Http\Controllers\TravelController;




Route::middleware(['auth:sanctum', RedisRateLimiter::class])->group(function () {
    Route::post('/travel-plans', [TravelController::class, 'generateTravelPlan']);
    Route::get('/recent-searches', [TravelController::class, 'recentSearches']);
});
