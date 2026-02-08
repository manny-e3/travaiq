<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GooglePlacesHelper
{
    /**
     * Get a photo URL for a location using Google Places API
     *
     * @param string $locationName The name of the location
     * @param string|null $apiKey Google Places API key (optional, will use env variable if not provided)
     * @param int $maxWidth Maximum width of the image
     * @return string The URL of the image or an error message
     */
    public static function getPlacePhotoUrl($locationName, $apiKey = null, $maxWidth = 800)
    {
        // Use provided API key or get from environment
        $apiKey = $apiKey ?? env('GOOGLE_MAPS_API_KEY');

        if (empty($apiKey)) {
            Log::error('Google Places API key not found in environment variables');
            return 'Error: API key not provided.';
        }

        $cacheKey = 'google_place_img_' . md5($locationName . $maxWidth);

        // Try to get from cache first
        return Cache::remember($cacheKey, now()->addDays(30), function () use ($locationName, $apiKey, $maxWidth) {
            
            // Step 1: Get place_id from place name
            $findResponse = Http::get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
                'input'     => $locationName,
                'inputtype' => 'textquery',
                'fields'    => 'place_id',
                'key'       => $apiKey,
            ]);

            if ($findResponse->failed() || !isset($findResponse['candidates'][0]['place_id'])) {
                Log::warning('No place_id found for location', [
                    'location' => $locationName,
                    'response' => $findResponse->json()
                ]);
                return 'Error: No place_id found.';
            }

            $placeId = $findResponse['candidates'][0]['place_id'];

            // Step 2: Use place_id to get photo_reference
            $detailsResponse = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                'place_id' => $placeId,
                'fields'   => 'photos',
                'key'      => $apiKey,
            ]);

            if ($detailsResponse->failed() || !isset($detailsResponse['result']['photos'][0]['photo_reference'])) {
                Log::warning('No photo_reference found for place', [
                    'place_id' => $placeId,
                    'response' => $detailsResponse->json()
                ]);
                return 'Error: No photo_reference found.';
            }

            $photoReference = $detailsResponse['result']['photos'][0]['photo_reference'];

            // Step 3: Construct photo URL
            $photoUrl = 'https://maps.googleapis.com/maps/api/place/photo?' . http_build_query([
                'maxwidth'       => $maxWidth,
                'photoreference' => $photoReference,
                'key'            => $apiKey,
            ]);

            Log::info('Successfully generated photo URL', [
                'location' => $locationName,
                'photo_url' => $photoUrl
            ]);

            return $photoUrl;
        });
    }
}
