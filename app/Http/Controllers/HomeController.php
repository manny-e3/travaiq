<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripDetail;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch some public trips for the homepage examples
        // If no public trips exist, it will just be an empty collection, which the view should handle
        $exampleTrips = TripDetail::latest()
                                  ->take(3)
                                  ->get();

        return view('pages.welcome', compact('exampleTrips'));
    }
}
