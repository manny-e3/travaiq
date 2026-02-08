<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Google_Client;

class GoogleOneTapController extends Controller
{
   public function login(Request $request)
{
    $credential = $request->input('credential');
    $client = new \Google_Client(['client_id' => config('services.google.client_id')]);
    $payload = $client->verifyIdToken($credential); // no return here

    if ($payload) {
        $email = $payload['email'];
        $google_id = $payload['sub'];
        $picture = $payload['picture'] ?? null;
        $name = $payload['name'] ?? '';

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'google_id' => $google_id,
                'picture' => $picture,
                'email_verified_at' => now(),
                'password' => bcrypt(str()->random(12)), // optional
            ]
        );

        Auth::login($user);
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false], 401);
    }
}

}