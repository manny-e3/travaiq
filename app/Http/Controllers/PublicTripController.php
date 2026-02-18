<?php

namespace App\Http\Controllers;

use App\Models\TripDetail;
use Illuminate\Http\Request;

class PublicTripController extends Controller
{
    public function show($reference, $location = null)
    {
        $trip = TripDetail::with(['locationOverview.itineraries.activities'])
            ->where('reference_code', $reference)
            ->firstOrFail();

        // SEO Canonicalization: Check if URL location slug matches trip location
        $expectedSlug = \Illuminate\Support\Str::slug($trip->location);
        if ($location !== $expectedSlug) {
             return redirect()->route('public.trip.show', ['reference' => $trip->reference_code, 'location' => $expectedSlug], 301);
        }

        return view('public.trips.show', compact('trip'));
    }

    public function seoLanding($location, $days)
    {
        // For now, we can just search for relevant trips or return a placeholder
        $trips = TripDetail::where('location', 'LIKE', "%{$location}%")
            ->where('duration', 'LIKE', "%{$days}%")
            ->get();

        return view('public.trips.landing', compact('location', 'days', 'trips'));
    }

    public function index()
    {
       TripDetail::latest()->paginate(1);
        return view('public.trips.index', compact('trips'));
    }
}
