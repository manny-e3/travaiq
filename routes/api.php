<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Middleware\RedisRateLimiter;
use App\Http\Controllers\TravelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/hotels/search', [TestController::class, 'search']);


Route::middleware(['auth:sanctum', RedisRateLimiter::class])->group(function () {
    Route::post('/travel-plans', [TravelController::class, 'generateTravelPlan']);
    Route::get('/recent-searches', [TravelController::class, 'recentSearches']);
});
