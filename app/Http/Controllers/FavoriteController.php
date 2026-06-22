<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\TripDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);

    }

    /**
     * Toggle favorite/unfavorite status for a trip.
     */
    public function toggleFavorite($tripId)
    {
        $user = Auth::user();
        $trip = TripDetail::findOrFail($tripId);

        $favorite = Favorite::where('user_id', $user->id)
            ->where('trip_detail_id', $trip->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $favorited = false;
            $message = 'Trip removed from your favorites.';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'trip_detail_id' => $trip->id,
            ]);
            $favorited = true;
            $message = 'Trip added to your favorites!';

            // Send standard Laravel database notification
            $user->notify(new \App\Notifications\TripActionNotification("You favorited the trip to {$trip->location}."));
        }

        return response()->json([
            'success' => true,
            'favorited' => $favorited,
            'message' => $message,
        ]);
    }

    /**
     * Toggle public/private visibility of a trip.
     */
    public function toggleVisibility($tripId)
    {
        $user = Auth::user();
        $trip = TripDetail::findOrFail($tripId);

        // Check ownership
        if ($trip->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.',
            ], 403);
        }

        $trip->is_public = !$trip->is_public;
        $trip->save();

        $status = $trip->is_public ? 'public' : 'private';
        $message = "Your trip is now {$status}.";

        // Notify user
        $user->notify(new \App\Notifications\TripActionNotification("Your trip to {$trip->location} is now {$status}."));

        return response()->json([
            'success' => true,
            'is_public' => $trip->is_public,
            'message' => $message,
        ]);
    }
}
