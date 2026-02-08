<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\GoogleOneTapController;

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return "Cache cleared successfully!";
});

Route::get('/', function () {
    return view('pages.welcome');
});

Route::get('/create-plan', function () {
    return view('pages.createPlan');
})->name('createPlan');



// Authentication Routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');




// Authentication routes
Route::post('/google-onetap-login', [GoogleOneTapController::class, 'login']);
Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

Route::post('/login-post', [AuthController::class, 'loginPost'])->name('loginPost');
Route::post('/forget-password', [AuthController::class, 'userForgetpassword'])->name('userForgetpassword');
Route::get('/forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forgetPassword');
Route::get('/password/reset/{token}', [AuthController::class, 'resetpassword']);
Route::post('/reset-password-submit', [AuthController::class, 'resetpasswordsubmit'])->name('resetpasswordsubmit');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/login-register', [AuthController::class, 'showLoginRegisterForm'])->name('loginRegister');
Route::post('/register-post', [AuthController::class, 'registerPost'])->name('registerPost');

// Travel Routes
Route::get('/travel/form', [TravelController::class, 'showForm'])->name('travel.form');
Route::post('/travel/generate', [TravelController::class, 'generateTravelPlan'])->name('travel.generate');
Route::get('/my-trips', [TravelController::class, 'myTrips'])->name('my.trips')->middleware('auth');
Route::get('/download-itinerary/{tripId}', [TravelController::class, 'downloadTrip'])->name('download.itinerary');

// Specific routes first
Route::get('/trips/temp', [TravelController::class, 'showTemp'])->name('trips.show.temp');
Route::get('/trips/reference/{referenceCode}', [TravelController::class, 'showByReference'])->name('trips.show.reference');
Route::get('/update-missing-images', [TravelController::class, 'updateMissingImages'])->name('update.missing.images');

// Parameterized routes last
Route::get('/trips/{tripId}', [TravelController::class, 'show'])->name('trips.show');

// Route for generating travel plan (assuming you already have this)
Route::post('/generate-travel-plan', [TravelController::class, 'generateTravelPlan'])->name('travel.generate');

Route::get('/travel-guide', [PublicController::class, 'travelGuide'])->name('travel.guide');
Route::get('/terms-of-service', [PublicController::class, 'termsOfService'])->name('terms.of.service');
Route::get('/privacy-policy', [PublicController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/cookie-policy', [PublicController::class, 'cookiePolicy'])->name('cookie.policy');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/faqs', [PublicController::class, 'faqs'])->name('faqs');
Route::get('/sitemap', [PublicController::class, 'sitemap'])->name('sitemap');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/test/hotels', [TravelController::class, 'testHotelIntegration'])->name('test.hotels');

// LOGIN REQUIRED ROUTES
Route::get('/my-trips', [TravelController::class, 'myTrips'])->name('my.trips')->middleware('auth');


// Add this route for testing hotel integration
Route::get('/test-hotel-integration', [TravelController::class, 'testHotelIntegration'])
    ->middleware(['auth'])
    ->name('test.hotel.integration');

Route::get('/location-search', [SearchController::class, 'showSearchForm'])->name('location.search');
Route::get('/api/location-suggestions', [SearchController::class, 'search'])->name('location.suggestions');
Route::get('/api/place-image', function (Illuminate\Http\Request $request) {
    $location = $request->query('location');
    if (!$location) {
        return response()->json(['error' => 'Location required'], 400);
    }
    
    // Activity Management Routes - Moved outside
    

    // Cache for 1 hour at the HTTP level if possible, but we are using internal cache in helper
    // We return JSON so frontend can consume it easily
    $url = App\Helpers\GooglePlacesHelper::getPlacePhotoUrl($location);
    
    if (str_starts_with($url, 'Error:')) {
        return response()->json(['error' => $url], 404);
    }
    
    return response()->json(['url' => $url]);
})->name('api.place.image');

// Activity Management Routes
Route::delete('/activities/{activity}', [TravelController::class, 'deleteActivity'])->name('activities.delete');
// Add this route for alternatives
Route::get('/activities/{activity}/alternatives', [TravelController::class, 'getAlternativeActivities'])->name('activities.alternatives');
Route::put('/activities/{activity}/replace', [TravelController::class, 'replaceActivity'])->name('activities.replace');

// Add Activity Routes
Route::get('/itineraries/{itinerary}/suggestions', [TravelController::class, 'getAddActivitySuggestions'])->name('activities.suggestions');
Route::post('/itineraries/{itinerary}/activities', [TravelController::class, 'storeActivity'])->name('activities.store');