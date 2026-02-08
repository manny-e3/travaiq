<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TripController extends Controller
{
    private function getPlacePhoto($location)
    {
        try {
            $apiKey = config('services.google.maps_api_key');

            // First, search for the place to get its place_id
            $searchResponse = Http::get('https://maps.googleapis.com/maps/api/place/findplacefromtext/json', [
                'input' => $location,
                'inputtype' => 'textquery',
                'fields' => 'place_id',
                'key' => $apiKey
            ]);

            if ($searchResponse->successful()) {
                $placeId = $searchResponse->json()['candidates'][0]['place_id'] ?? null;

                if ($placeId) {
                    // Then get the place details including photos
                    $detailsResponse = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                        'place_id' => $placeId,
                        'fields' => 'photos',
                        'key' => $apiKey
                    ]);

                    if ($detailsResponse->successful()) {
                        return $detailsResponse->json()['result']['photos'][0]['photo_reference'] ?? null;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error fetching place photo: ' . $e->getMessage());
        }

        return null;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string',
            'duration' => 'required|integer',
            'budget' => 'required|string',
            // Add other validation rules as needed
        ]);

        // Get photo reference from Google Places API
        $photoReference = $this->getPlacePhoto($validated['location']);

        // Create the trip with the photo reference
        $trip = Trip::create([
            'location' => $validated['location'],
            'duration' => $validated['duration'],
            'budget' => $validated['budget'],
            'photo_reference' => $photoReference,
            // Add other fields as needed
        ]);

        return redirect()->route('my.trips')->with('success', 'Trip created successfully!');
    }

    public function index()
    {
        $trips = Trip::latest()->get();
        return view('myTrips', compact('trips'));
    }
}
