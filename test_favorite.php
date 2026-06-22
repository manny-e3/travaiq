<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\TripDetail;
use App\Models\Favorite;

try {
    $user = User::find(35); // CHIOMA MBAGWU
    if (!$user) {
        $user = User::first();
    }
    
    // Find any trip detail
    $trip = TripDetail::first();
    if (!$trip) {
        echo "No trips found in database to favorite.\n";
        exit;
    }
    
    echo "Using User ID: {$user->id}, Name: {$user->name}\n";
    echo "Using Trip ID: {$trip->id}, Location: {$trip->location}\n";
    
    $favorite = Favorite::where('user_id', $user->id)
        ->where('trip_detail_id', $trip->id)
        ->first();
        
    if ($favorite) {
        echo "Favorite exists, deleting...\n";
        $favorite->delete();
        echo "Deleted.\n";
    } else {
        echo "Favorite does not exist, creating...\n";
        Favorite::create([
            'user_id' => $user->id,
            'trip_detail_id' => $trip->id,
        ]);
        echo "Created.\n";
        
        echo "Sending notification...\n";
        $user->notify(new \App\Notifications\TripActionNotification("You favorited the trip to {$trip->location}."));
        echo "Notification sent.\n";
    }
} catch (\Exception $e) {
    echo "Exception occurred: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
