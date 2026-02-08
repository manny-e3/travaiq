<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Cost;
use App\Models\User;
use App\Models\Activity;
use App\Mail\WelcomeUser;
use App\Models\Itinerary;
use App\Models\DiningCost;
use App\Models\TripDetail;
use App\Models\VerifyUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SecurityAdvice;
use App\Mail\ForgotPasswordMail;
use App\Models\LocationOverview;
use App\Models\TransportationCost;
use Illuminate\Support\Facades\DB;
use App\Models\HotelRecommendation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\AdditionalInformation;

class AuthService
{
    /**
     * Register a new user.
     */
    public function register(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = Str::random(60);

        // Email Data
        $email_data = [
            'email'     => $user->email,
            'name' => $user->name,
        ];

        Mail::to($email_data['email'])->queue(new WelcomeUser($email_data));

        // Log in the user automatically after registration
        Auth::login($user);

        // Save temporary travel plan if it exists
        $tripDetail = $this->saveTempTravelPlan($user);

        return [
            'status' => true, 
            'success' => 'Register successful',
            'tripDetail' => $tripDetail,
            'user' => $user
        ];
    }

    /**
     * Authenticate user login.
     */
    public function login($credentials)
    {
        if (! Auth::attempt($credentials)) {
            return ['status' => false, 'error' => 'Invalid login credentials'];
        }

        $user = Auth::user();

        // Save temporary travel plan if it exists
        $tripDetail = $this->saveTempTravelPlan($user);

        return [
            'status' => true, 
            'success' => 'Login successful',
            'tripDetail' => $tripDetail
        ];
    }

    /**
     * Send password reset link (custom implementation).
     */
    public function forgetPassword(string $email)
    {
        $user = User::where('email', $email)->first();
        if (! $user) {
            return false;
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email'      => $email,
            'token'      => $token,
            'created_at' => Carbon::now(),
        ]);

        $email_data = [
            'token'     => $token,
            'email'     => $email,
            'name' => $user->name,
        ];

      

        Mail::to($email_data['email'])->queue(new ForgotPasswordMail($email_data));

        return true;
    }

    /**
     * Get password reset view.
     */
    public function getResetPasswordView($token)
    {
        $passwordReset = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (! $passwordReset) {
            return null;
        }

        return [
            'token' => $token,
            'email' => $passwordReset->email,
        ];
    }

    /**
     * Handle password reset submission.
     */
    public function resetPasswordSubmit(array $data)
    {
         $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $data['email'],
                'token' => $data['token'],
            ])
            ->first();

            //dd($updatePassword);

        if (! $updatePassword) {
            return 'Invalid token!';
        }

        $user = User::where('email', $data['email'])->first();
        if (! $user) {
            return 'User not found.';
        }

        // Update user's password
        $user->password            = Hash::make($data['password']);
        $user->save();

        // Remove password reset record
       DB::table('password_reset_tokens')->where(['email' => $data['email']])->delete();

        return true;
    }

    public function verifyEmail($token)
    {
        $verifiedUser = VerifyUser::where('token', $token)->first();

        if (! $verifiedUser) {
            return [
                'status'  => false,
                'message' => 'Invalid or expired verification token.',
            ];
        }

        $user = $verifiedUser->user;

        if (! $user->email_verified_at) {
            $user->email_verified_at = Carbon::now();
            $user->save();

            return [
                'status'  => true,
                'message' => 'Your email has been verified.',
            ];
        }

        return [
            'status'  => true,
            'message' => 'Your email has already been verified. Login to continue.',
        ];
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully');
    }


      private function saveTempTravelPlan($user)
    {
        $tempPlan = session('temp_travel_plan');
       //dd($tempPlan);
        // Add debug logging
        Log::info('Attempting to save temp travel plan', [
            'has_temp_plan' => !empty($tempPlan),
            'session_data' => session()->all(),
            'user_id' => $user->id
        ]);

        if (!$tempPlan) {
            Log::info('No temporary travel plan found in session');
            return null;
        }

        try {
            DB::beginTransaction();

            // Log the temp plan data structure
            Log::info('Temp plan structure', [
                'keys' => array_keys($tempPlan),
                'plan_keys' => isset($tempPlan['plan']) ? array_keys($tempPlan['plan']) : 'no plan key'
            ]);

            // Create trip detail
            $tripDetail = TripDetail::create([
                'reference_code' => $tempPlan['reference_code'],
                'location' => $tempPlan['location'],
                'duration' => $tempPlan['duration'],
                'traveler' => $tempPlan['traveler'],
                'budget' => $tempPlan['budget'],
                'activities' => $tempPlan['activities'],
                'user_id' => $user->id,
            ]);

            Log::info('Created trip detail', ['trip_detail_id' => $tripDetail->id]);

            // Create location overview
            $locationOverview = LocationOverview::create([
                'history_and_culture' => $tempPlan['plan']['location_overview']['history_and_culture'],
                'local_customs_and_traditions' => $tempPlan['plan']['location_overview']['local_customs_and_traditions'],
                'geographic_features_and_climate' => $tempPlan['plan']['location_overview']['geographic_features_and_climate'],
            ]);

            Log::info('Created location overview', ['location_overview_id' => $locationOverview->id]);

            // Create security advice
            $securityAdvice = SecurityAdvice::create([
                'location_overview_id' => $locationOverview->id,
                'overall_safety_rating' => $tempPlan['plan']['location_overview']['security_advice']['overall_safety_rating'],
                'emergency_numbers' => $tempPlan['plan']['location_overview']['security_advice']['emergency_numbers'],
                'areas_to_avoid' => $tempPlan['plan']['location_overview']['security_advice']['areas_to_avoid'],
                'common_scams' => $tempPlan['plan']['location_overview']['security_advice']['common_scams'],
                'safety_tips' => $tempPlan['plan']['location_overview']['security_advice']['safety_tips'],
                'health_precautions' => $tempPlan['plan']['location_overview']['security_advice']['health_precautions'],
            ]);

            Log::info('Created security advice', ['security_advice_id' => $securityAdvice->id]);

            



            foreach ($tempPlan['plan']['agoda_hotels'] as $hotelData) {
                HotelRecommendation::create([
                    'location_overview_id' => $locationOverview->id,
                    'name' => $hotelData['name'],
                    'description' => $hotelData['description'],
                    'address' => $hotelData['address'],
                    'rating' => $hotelData['rating'],
                    'price' => $hotelData['price'],
                    'currency' => $hotelData['currency'],
                    'image_url' => $hotelData['image_url'],
                    'amenities' => json_encode($hotelData['amenities']),
                    'location' => json_encode($hotelData['location']),
                    'review_score' => $hotelData['review_score'],
                    'review_count' => $hotelData['review_count'],
                    'booking_url' => $hotelData['booking_url'],
                ]);
            }

            // Create itineraries and activities
            foreach ($tempPlan['plan']['itinerary'] as $dayPlan) {
                $itinerary = Itinerary::create([
                    'day' => $dayPlan['day'],
                    'location_overview_id' => $locationOverview->id,
                ]);

                Log::info('Created itinerary', ['itinerary_id' => $itinerary->id, 'day' => $dayPlan['day']]);

                foreach ($dayPlan['activities'] as $activityData) {
                    $activityData['itinerary_id'] = $itinerary->id;
                    $activityData['location_overview_id'] = $locationOverview->id;
                    $activity = Activity::create($activityData);
                    Log::info('Created activity', ['activity_id' => $activity->id, 'name' => $activity->name]);
                }
            }

            

            // Create costs
            foreach ($tempPlan['plan']['costs'] as $costData) {
                $cost = Cost::create([
                    'location_overview_id' => $locationOverview->id,
                    'currency' => $costData['currency'] ?? 'USD', // Default to USD if not specified
                    'total_cost' => $costData['total_cost'] ?? 0, // Default to 0 if not specified
                    'category' => $costData['category'] ?? 'General', // Default category
                    'description' => $costData['description'] ?? '', // Default empty description
                ]);

                Log::info('Created cost', ['cost_id' => $cost->id]);

                // Create transportation costs
                if (isset($costData['transportation']) && is_array($costData['transportation'])) {
                    foreach ($costData['transportation'] as $transportData) {
                        $transport = TransportationCost::create([
                            'cost_id' => $cost->id,
                            'location_overview_id' => $locationOverview->id,
                            'type' => $transportData['type'] ?? 'Other',
                            'cost' => $transportData['cost'] ?? 'Not specified',
                            'cost_range' => $transportData['cost_range'] ?? 'Not specified'
                        ]);
                        Log::info('Created transportation cost', ['transport_id' => $transport->id]);
                    }
                }

                // Create dining costs
                if (isset($costData['dining']) && is_array($costData['dining'])) {
                    foreach ($costData['dining'] as $diningData) {
                        $dining = DiningCost::create([
                            'cost_id' => $cost->id,
                            'location_overview_id' => $locationOverview->id,
                            'category' => $diningData['category'] ?? 'Other',
                            'cost_range' => $diningData['cost_range'] ?? 'Not specified'
                        ]);
                        Log::info('Created dining cost', ['dining_id' => $dining->id]);
                    }
                }
            }

            // Create additional information
            $additionalInfo = AdditionalInformation::create([
                'location_overview_id' => $locationOverview->id,
                'local_currency' => $tempPlan['plan']['additional_information']['local_currency'],
                'timezone' => $tempPlan['plan']['additional_information']['timezone'],
                'weather_forecast' => $tempPlan['plan']['additional_information']['weather_forecast'],
                'transportation_options' => $tempPlan['plan']['additional_information']['transportation_options'],
                'exchange_rate' => $tempPlan['plan']['additional_information']['exchange_rate'] ?? 1.0, // Default to 1.0 if not specified
            ]);

            Log::info('Created additional information', ['additional_info_id' => $additionalInfo->id]);

            // Update trip detail with location overview
            $tripDetail->update(['location_overview_id' => $locationOverview->id]);

            DB::commit();

            // Clear the temporary plan from session
            session()->forget('temp_travel_plan');

            Log::info('Successfully saved temporary travel plan', [
                'trip_detail_id' => $tripDetail->id,
                'location_overview_id' => $locationOverview->id
            ]);

            return $tripDetail;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving temporary travel plan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user->id,
                'temp_plan_structure' => isset($tempPlan) ? array_keys($tempPlan) : 'no temp plan'
            ]);
            return null;
        }
    }
}
