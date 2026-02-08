<?php
namespace App\Http\Controllers;

use App\Helpers\GooglePlacesHelper;
use App\Models\Activity;
use App\Models\AdditionalInformation;
use App\Models\Cost;
use App\Models\DiningCost;
use App\Models\Hotel;
use App\Models\Itinerary;
use App\Models\LocationOverview;
use App\Models\SecurityAdvice;
use App\Models\TransportationCost;
use App\Models\TripDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Prompts\TravelPlanPrompt;
use App\Models\RequestLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use App\Services\HotelRecommendationService;
use App\Models\HotelRecommendation;
use App\Models\UserRequest;

class TravelPlanException extends Exception
{
    protected $context;

    public function __construct($message, $context = [], $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }
}

class TravelController extends Controller
{
    private $hotelRecommendationService;

    public function __construct(HotelRecommendationService $hotelRecommendationService)
    {
        $this->hotelRecommendationService = $hotelRecommendationService;
    }

    private function logError($message, $context = [], $exception = null)
    {
        $logContext = array_merge($context, [
            'trace' => $exception ? $exception->getTraceAsString() : null,
            'file' => $exception ? $exception->getFile() : null,
            'line' => $exception ? $exception->getLine() : null,
        ]);

        Log::error($message, $logContext);
    }

    private function handleError($exception, $request)
    {
        $errorMessage = 'An error occurred while generating your travel plan.';
        $errorDetails = null;

        if ($exception instanceof TravelPlanException) {
            $errorMessage = $exception->getMessage();
            $errorDetails = $exception->getContext();
        } elseif ($exception instanceof \JsonException) {
            $errorMessage = 'Failed to process the travel plan data. Please try again.';
        } elseif ($exception instanceof \Illuminate\Database\QueryException) {
            $errorMessage = 'Database error occurred. Please try again later.';
        }

        $this->logError($errorMessage, [
            'error' => $exception->getMessage(),
            'request_data' => $request->all(),
            'error_details' => $errorDetails
        ], $exception);

        return redirect()->back()
            ->with('error', $errorMessage)
            ->with('error_details', $errorDetails)
            ->withInput();
    }

    private function validateTravelPlan($travelPlan, $totalDays)
    {
        $errors = [];

        // Validate total days
        if (count($travelPlan['itinerary']) < $totalDays) {
            $errors[] = "Incomplete itinerary: Expected {$totalDays} days but received " . count($travelPlan['itinerary']) . " days";
        }

        // Validate activities per day
        foreach ($travelPlan['itinerary'] as $dayPlan) {
            $dayNumber = $dayPlan['day'];
            $activityCount = count($dayPlan['activities']);
            
            if ($activityCount < 3) { // Reduced minimum to 3 activities per day
                $errors[] = "Day {$dayNumber} has only {$activityCount} activities. Please try generating the plan again.";
            }
        }

        // Validate required sections
        $requiredSections = [
            'location_overview',
            'costs',
            'additional_information'
        ];

        foreach ($requiredSections as $section) {
            if (!isset($travelPlan[$section])) {
                $errors[] = "Missing required section: {$section}";
            }
        }

        if (!empty($errors)) {
            throw new TravelPlanException('Travel plan validation failed', [
                'errors' => $errors,
                'total_days' => $totalDays,
                'received_days' => count($travelPlan['itinerary']),
                'plan_summary' => [
                    'days_with_activities' => array_map(function($day) {
                        return [
                            'day' => $day['day'],
                            'activity_count' => count($day['activities'])
                        ];
                    }, $travelPlan['itinerary'])
                ]
            ]);
        }
    }

  public function generateTravelPlan(Request $request)
{
    set_time_limit(300);

    UserRequest::create([
        'location' => $request->location,
        'travel_date' => \Carbon\Carbon::parse($request->travel),
        'duration' => $request->duration,
        'budget' => $request->budget,
        'traveler_type' => $request->traveler,
        'activities' => $request->activities,
        'user_country' => $request->country,   
        'user_city' => $request->city,
        'user_ip' => $request->ip,
        'user_longitude' => $request->longitude,
        'user_latitude' => $request->latitude,
    ]);

    try {
        // Validate and extract required fields
        $validated = $request->validate([
            'location' => 'required|string',
            'duration' => 'required|integer',
            'traveler' => 'required|string',
            'budget' => 'required|string',
            'activities' => 'required|json',
            'travel' => 'required|date',
        ]);

        $startDate = Carbon::parse($validated['travel']);
        $duration = (int) $validated['duration'];
        $endDate = $startDate->copy()->addDays($duration);

        $checkInDate = $startDate->format('Y-m-d');
        $checkOutDate = $endDate->format('Y-m-d');

        $activitiesList = json_decode($validated['activities'], true);
        if (!is_array($activitiesList)) {
            throw new TravelPlanException('Invalid activities format', [
                'activities' => $validated['activities']
            ]);
        }

        $activities = implode(', ', $activitiesList);
        $referenceCode = strtoupper(Str::random(8));

        if (Auth::check()) {
            return \DB::transaction(function () use ($validated, $activities, $referenceCode, $checkInDate, $checkOutDate) {
                // RequestLog::create([
                //     'location' => $validated['location'],
                //     'duration' => $validated['duration'],
                //     'traveler' => $validated['traveler'],
                //     'budget' => $validated['budget'],
                //     'activities' => $validated['activities'],
                // ]);

                $tripDetail = TripDetail::create([
                    'reference_code' => $referenceCode,
                    'location' => $validated['location'],
                    'duration' => $validated['duration'],
                    'traveler' => $validated['traveler'],
                    'budget' => $validated['budget'],
                    'activities' => $activities,
                    'user_id' => Auth::id(),
                ]);
                if (!$tripDetail) {
                    throw new Exception('Failed to create TripDetail');
                }

               // dd($validated['budget']);

                $travelPlan = $this->generateAndProcessTravelPlan(
                    $validated['location'],
                    $validated['duration'],
                    $validated['traveler'],
                    $validated['budget'],
                    $activities
                );

                $locationOverview = $this->saveTravelPlanToDatabase($travelPlan, $tripDetail, $checkInDate, $checkOutDate, $validated['budget']);

                if (!$locationOverview || !isset($locationOverview->id)) {
                    throw new Exception('Failed to retrieve or create LocationOverview.');
                }

                // Fetch hotels and attach to session for display if needed
                $hotels = HotelRecommendation::where('location_overview_id', $locationOverview->id)->get();
                session(['latest_hotels' => $hotels]);

                return redirect()->route('trips.show', $locationOverview->id)
                    ->with('reference_code', $referenceCode)
                    ->with('success', 'Travel plan generated successfully!');
            });
        }

        // For unauthenticated users
        $travelPlan = $this->generateAndProcessTravelPlan(
            $validated['location'],
            $validated['duration'],
            $validated['traveler'],
            $validated['budget'],
            $activities
        );

        // Attach Google Places image
        // Images will be fetched by the frontend
        foreach ($travelPlan['itinerary'] as &$itinerary) {
            foreach ($itinerary['activities'] as &$activity) {
                $activity['image_url'] = null;
            }
        }
        unset($itinerary, $activity);

        $tempPlanData = [
            'plan' => $travelPlan,
            'reference_code' => $referenceCode,
            'location' => $validated['location'],
            'duration' => $validated['duration'],
            'traveler' => $validated['traveler'],
            'budget' => $validated['budget'],
            'activities' => $activities,
            'created_at' => now(),
            'check_in_date' => $checkInDate,
            'check_out_date' => $checkOutDate,
        ];

        session(['temp_travel_plan' => $tempPlanData]);

        return redirect()->route('trips.show.temp')
            ->with('reference_code', $referenceCode)
            ->with('success', 'Travel plan generated successfully!');
    } catch (Exception $e) {
        Log::error('Error in generateTravelPlan', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all(),
            'session_state' => [
                'session_id' => session()->getId(),
                'all_session_keys' => array_keys(session()->all())
            ]
        ]);

        return $this->handleError($e, $request);
    }
}


    private function generateAndProcessTravelPlan($location, $totalDays, $traveler, $budget, $activities)
    {
        try {
            $prompt = TravelPlanPrompt::generate($location, $totalDays, $traveler, $budget, $activities);
            $apiKey = env('GOOGLE_GEN_AI_API_KEY');

            if (empty($apiKey)) {
                throw new TravelPlanException('AI service configuration error', [
                    'service' => 'Gemini AI'
                ]);
            }
            

            $response = Http::timeout(60)
                ->retry(3, 5000)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$apiKey", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                ]);

            if (!$response->successful()) {
                throw new TravelPlanException('Failed to generate travel plan from AI service', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
            }

            // Process AI response
            $responseBody = $response->json();
            $generatedText = $responseBody['candidates'][0]['content']['parts'][0]['text'];
            $generatedText = preg_replace('/```json\s*|\s*```/', '', $generatedText);
            $generatedText = trim($generatedText);

            try {
                $travelPlan = json_decode($generatedText, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                throw new TravelPlanException('Invalid AI response format', [
                    'response' => $generatedText
                ]); 
            }

            // Validate the travel plan
            $this->validateTravelPlan($travelPlan, $totalDays);

            return $travelPlan;
        } catch (Exception $e) {
            Log::error('Error in generateAndProcessTravelPlan', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'location' => $location,
                'totalDays' => $totalDays,
                'traveler' => $traveler,
                'budget' => $budget,
                'activities' => $activities
            ]);
            throw $e;
        }
    }

    private function saveTravelPlanToDatabase($travelPlan, $tripDetail,  $checkInDate , $checkOutDate, $budget)
    {
        // Step 5: Create location overview and related data
        $locationOverview = LocationOverview::create([
            'history_and_culture' => $travelPlan['location_overview']['history_and_culture'],
            'local_customs_and_traditions' => $travelPlan['location_overview']['local_customs_and_traditions'],
            'geographic_features_and_climate' => $travelPlan['location_overview']['geographic_features_and_climate'],
        ]);
        if (!$locationOverview) {
            throw new Exception('Failed to create LocationOverview');
        }

        // Step 6: Batch create related data
        $this->createSecurityAdvice($locationOverview, $travelPlan);
        $this->createHistoricalLandmarks($locationOverview, $travelPlan);
        $this->createCulturalHighlights($locationOverview, $travelPlan);
        $this->createItinerary($locationOverview, $travelPlan);
        $this->createCosts($locationOverview, $travelPlan);
        $this->createAdditionalInfo($locationOverview, $travelPlan);

        // Get Agoda hotel recommendations
        $agodaHotels = $this->hotelRecommendationService->getHotelRecommendations(
            $tripDetail->location, $checkInDate, $checkOutDate, $budget
        );
        if (!empty($agodaHotels)) {
            foreach ($agodaHotels as $hotel) {
                HotelRecommendation::create([
                    'location_overview_id' => $locationOverview->id,
                    'name' => $hotel['name'],
                    'description' => $hotel['description'],
                    'address' => $hotel['address'],
                    'rating' => $hotel['rating'],
                    'price' => $hotel['price'],
                    'currency' => $hotel['currency'],
                    'image_url' => $hotel['image_url'],
                    'amenities' => json_encode($hotel['amenities']),
                    'location' => json_encode($hotel['location']),
                    'review_score' => $hotel['review_score'],
                    'review_count' => $hotel['review_count'],
                    'booking_url' => $hotel['booking_url']
                ]);
            }
        }

        // Update trip detail with location overview
        $tripDetail->update(['location_overview_id' => $locationOverview->id]);

        // Get Google Places image in parallel
        $this->updateGooglePlaceImage($tripDetail, $tripDetail->location);

        return $locationOverview;
    }

    private function createSecurityAdvice($locationOverview, $travelPlan)
    {
        $securityAdvice = SecurityAdvice::create([
            'location_overview_id' => $locationOverview->id,
            'overall_safety_rating' => data_get($travelPlan, 'location_overview.security_advice.overall_safety_rating'),
            'emergency_numbers' => data_get($travelPlan, 'location_overview.security_advice.emergency_numbers'),
            'areas_to_avoid' => data_get($travelPlan, 'location_overview.security_advice.areas_to_avoid'),
            'common_scams' => data_get($travelPlan, 'location_overview.security_advice.common_scams'),
            'safety_tips' => data_get($travelPlan, 'location_overview.security_advice.safety_tips', []),
            'health_precautions' => data_get($travelPlan, 'location_overview.security_advice.health_precautions')
        ]);
        if (!$securityAdvice) {
            throw new Exception('Failed to create SecurityAdvice');
        }

        // Batch create emergency facilities
        $emergencyFacilities = collect(data_get($travelPlan, 'location_overview.security_advice.local_emergency_facilities', []))
            ->map(function ($facility) use ($securityAdvice) {
                return [
                    'name' => data_get($facility, 'name'),
                    'address' => data_get($facility, 'address'),
                    'phone' => data_get($facility, 'phone'),
                    'security_advice_id' => $securityAdvice->id
                ];
            })->toArray();

        if (!empty($emergencyFacilities)) {
            $securityAdvice->emergencyFacilities()->createMany($emergencyFacilities);
        }
    }

    private function createHistoricalLandmarks($locationOverview, $travelPlan)
    {
        $landmarks = collect(data_get($travelPlan, 'location_overview.historical_events_and_landmarks', []))
            ->map(function ($landmark) use ($locationOverview) {
                if (!$locationOverview) {
                    throw new Exception('LocationOverview is null in createHistoricalLandmarks');
                }
                return [
                    'name' => data_get($landmark, 'name', 'Unknown Landmark'),
                    'description' => data_get($landmark, 'description', 'No description available'),
                    'location_overview_id' => $locationOverview->id
                ];
            })->toArray();

        if (!empty($landmarks)) {
            $locationOverview->historicalEventsAndLandmarks()->createMany($landmarks);
        }
    }

    private function createCulturalHighlights($locationOverview, $travelPlan)
    {
        $highlights = collect($travelPlan['location_overview']['cultural_highlights'])
            ->map(function ($highlight) use ($locationOverview) {
                if (!$locationOverview) {
                    throw new Exception('LocationOverview is null in createCulturalHighlights');
                }
                $highlight['location_overview_id'] = $locationOverview->id;
                return $highlight;
            })->toArray();

        if (!empty($highlights)) {
            $locationOverview->culturalHighlights()->createMany($highlights);
        }
    }

    private function createItinerary($locationOverview, $travelPlan)
    {
        foreach ($travelPlan['itinerary'] as $dayPlan) {
            $itinerary = Itinerary::create([
                'day' => $dayPlan['day'],
                'location_overview_id' => $locationOverview->id,
            ]);
    
            $activities = collect($dayPlan['activities'])
                ->map(function ($activityData) use ($itinerary, $locationOverview) {
                    // Image URL will be fetched by frontend or processed in background
                    $imageUrl = null;

                    return [
                        'itinerary_id' => $itinerary->id,
                        'location_overview_id' => $locationOverview->id,
                        'name' => $activityData['name'] ?? '',
                        'description' => $activityData['description'] ?? '',
                        'coordinates' => $activityData['coordinates'] ?? '',
                        'address' => $activityData['address'] ?? '',
                        'cost' => $activityData['cost'] ?? '',
                        'duration' => $activityData['duration'] ?? '',
                        'best_time' => $activityData['best_time'] ?? '',
                        'phone_number' => $activityData['phone_number'] ?? '',
                        'website' => $activityData['website'] ?? '',
                        'fee' => $activityData['fee'] ?? '',
                        'image_url' => $imageUrl
                    ];
                })->toArray();

            if (!empty($activities)) {
                Activity::insert($activities);
            }
        }
    }

    private function createCosts($locationOverview, $travelPlan)
    {
        foreach ($travelPlan['costs'] as $costData) {
            $costData['location_overview_id'] = $locationOverview->id;
            $cost = Cost::create($costData);
            if (!$cost) {
                throw new Exception('Failed to create Cost');
            }

            $transportationCosts = collect($costData['transportation'])
                ->map(function ($transportData) use ($cost, $locationOverview) {
                    $transportData['cost_id'] = $cost->id;
                    $transportData['location_overview_id'] = $locationOverview->id;
                    return $transportData;
                })->toArray();

            $diningCosts = collect($costData['dining'])
                ->map(function ($diningData) use ($cost, $locationOverview) {
                    $diningData['cost_id'] = $cost->id;
                    $diningData['location_overview_id'] = $locationOverview->id;
                    return $diningData;
                })->toArray();

            if (!empty($transportationCosts)) {
                TransportationCost::insert($transportationCosts);
            }

            if (!empty($diningCosts)) {
                DiningCost::insert($diningCosts);
            }
        }
    }

    private function createAdditionalInfo($locationOverview, $travelPlan)
    {
        $additionalInfoData = $travelPlan['additional_information'];
        $additionalInfoData['location_overview_id'] = $locationOverview->id;
        $additionalInfo = AdditionalInformation::create($additionalInfoData);
        if (!$additionalInfo) {
            throw new Exception('Failed to create AdditionalInformation');
        }
    }

    private function updateGooglePlaceImage($tripDetail, $location)
    {
        $google_place_image = GooglePlacesHelper::getPlacePhotoUrl($location);
        if (!str_starts_with($google_place_image, 'Error:')) {
            $tripDetail->update(['google_place_image' => $google_place_image]);
        }
    }

    public function show($tripId)
    {
        $locationOverview = LocationOverview::with([
            'securityAdvice.emergencyFacilities',
            'historicalEventsAndLandmarks',
            'culturalHighlights',
        ])->findOrFail($tripId);

        $tripDetails = TripDetail::where('location_overview_id', $tripId)->firstOrFail();

        // Get Google Places image for the location if not already set
        if (!$tripDetails->google_place_image) {
            $google_place_image = GooglePlacesHelper::getPlacePhotoUrl($tripDetails->location);
            if (!str_starts_with($google_place_image, 'Error:')) {
                $tripDetails->update(['google_place_image' => $google_place_image]);
            }
        }

        // Get city ID for Agoda link
        $cityId = null;
        try {
            $suggestionResponse = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/91.0.4472.124 Safari/537.36',
                    'Accept' => 'application/json',
                ])->get('https://partners.agoda.com/HotelSuggest/GetSuggestions', [
                    'type' => 1,
                    'limit' => 10,
                    'term' => $tripDetails->location,
                ]);

            if ($suggestionResponse->successful()) {
                $suggestions = $suggestionResponse->json();
                if (!empty($suggestions) && is_array($suggestions)) {
                    $cityId = $suggestions[0]['Value'] ?? null;
                }
            }
        } catch (Exception $e) {
            Log::warning('Failed to get city ID for Agoda link', [
                'location' => $tripDetails->location,
                'error' => $e->getMessage()
            ]);
        }

        return view('pages.travelResult', [
            'tripId'                => $tripId,
            'locationOverview'      => $locationOverview,
            'securityAdvice'        => $locationOverview->securityAdvice,
            'hotels'                => HotelRecommendation::where('location_overview_id', $tripId)->get(),
            'itineraries'           => Itinerary::with('activities')
                ->where('location_overview_id', $tripId)
                ->orderBy('day')
                ->get(),
            'cost'                  => Cost::with(['transportationCosts', 'diningCosts'])
                ->where('location_overview_id', $tripId)
                ->firstOrFail(),
            'additionalInfo'        => AdditionalInformation::where('location_overview_id', $tripId)->first(),
            'tripDetails'           => $tripDetails,
            'referenceCode'         => $tripDetails->reference_code,
            'location'              => $tripDetails->location,
            'duration'              => $tripDetails->duration,
            'traveler'              => $tripDetails->traveler,
            'budget'                => $tripDetails->budget,
            'activities'            => $tripDetails->activities,
            'cityId'                => $cityId,
        ]);
    }

    public function showByReference($referenceCode)
    {
        $tripDetails = TripDetail::where('reference_code', $referenceCode)->firstOrFail();
        return redirect()->route('trips.show', $tripDetails->location_overview_id);
    }

    /**
     * Display all trips for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function myTrips()
    {
        $trips = TripDetail::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.myTrips', [
            'trips' => $trips,
        ]);
    }

    public function downloadTrip($tripId)
    {
        $locationOverview = LocationOverview::with([
            'securityAdvice.emergencyFacilities',
            'historicalEventsAndLandmarks',
            'culturalHighlights',
        ])->findOrFail($tripId);

        $tripDetails = TripDetail::where('location_overview_id', $tripId)->firstOrFail();

        $pdf = PDF::loadView('pdf.itinerary', [
            'locationOverview'      => $locationOverview,
            'securityAdvice'        => $locationOverview->securityAdvice,
            'hotels'                => Hotel::where('location_overview_id', $tripId)->get(),
            'itineraries'           => Itinerary::with('activities')
                ->where('location_overview_id', $tripId)
                ->orderBy('day')
                ->get(),
            'cost'                  => Cost::with(['transportationCosts', 'diningCosts'])
                ->where('location_overview_id', $tripId)
                ->firstOrFail(),
            'additionalInfo'        => AdditionalInformation::where('location_overview_id', $tripId)->first(),
            'tripDetails'           => $tripDetails,
            'referenceCode'         => $tripDetails->reference_code,
            'location'              => $tripDetails->location,
            'duration'              => $tripDetails->duration,
            'traveler'              => $tripDetails->traveler,
            'budget'                => $tripDetails->budget,
            'activities'            => $tripDetails->activities,
        ]);
        
        // return $pdf->download('itinerary.pdf');
        return $pdf->stream('itinerary.pdf');
    }
    
    // Add this new method to handle image updates
    private function updateImagesForExistingRecords()
    {
        // Update hotel images
        $hotels = Hotel::whereNull('image_url')->get();
        foreach ($hotels as $hotel) {
            if (!empty($hotel->name)) {
                try {
                    $imageUrl = GooglePlacesHelper::getPlacePhotoUrl($hotel->name);
                    if (!str_starts_with($imageUrl, 'Error:')) {
                        $hotel->update(['image_url' => $imageUrl]);
                    }
                } catch (Exception $e) {
                    Log::warning('Failed to update hotel image', [
                        'hotel_id' => $hotel->id,
                        'hotel_name' => $hotel->name,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        // Update activity images
        $activities = Activity::whereNull('image_url')->get();
        foreach ($activities as $activity) {
            if (!empty($activity->name)) {
                try {
                    $imageUrl = GooglePlacesHelper::getPlacePhotoUrl($activity->name);
                    if (!str_starts_with($imageUrl, 'Error:')) {
                        $activity->update(['image_url' => $imageUrl]);
                    }
                } catch (Exception $e) {
                    Log::warning('Failed to update activity image', [
                        'activity_id' => $activity->id,
                        'activity_name' => $activity->name,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
    }

    // Add this method to your controller
    public function updateMissingImages()
    {
        try {
            $this->updateImagesForExistingRecords();
            return redirect()->back()->with('success', 'Images updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update images: ' . $e->getMessage());
        }
    }

    public function deleteActivity($id)
    {
        Log::info("deleteActivity called with ID: " . $id);
        
        $activity = Activity::find($id);

        if (!$activity) {
            Log::error("Activity with ID {$id} not found.");
            return response()->json(['error' => 'Activity not found'], 404);
        }

        // Verify ownership (if user logged in)
        if (Auth::check()) {
            if (!$activity->itinerary) {
                Log::error("Activity {$activity->id} has no itinerary relation.");
                return response()->json(['error' => 'Activity data integrity error'], 500);
            }

            $tripDetail = TripDetail::where('location_overview_id', $activity->itinerary->location_overview_id)->first();
            
            if (!$tripDetail) {
                 Log::error("TripDetail not found for location_overview_id: " . $activity->itinerary->location_overview_id);
                 return response()->json(['error' => 'Trip not found'], 404);
            }

            if ($tripDetail->user_id !== Auth::id()) {
               Log::warning("Unauthorized delete attempt. User: " . Auth::id() . ", Trip Owner: " . $tripDetail->user_id);
               return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        try {
            $activity->delete();
            Log::info("Activity {$activity->id} deleted successfully.");
            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error("Failed to delete activity: " . $e->getMessage());
            return response()->json(['error' => 'Delete failed'], 500);
        }
    }

    public function getAlternativeActivities($id)
    {
        Log::info("getAlternativeActivities called with ID: " . $id);
        
        $activity = Activity::with('itinerary.locationOverview')->find($id);

        if (!$activity) {
            return response()->json(['error' => 'Activity not found'], 404);
        }

        // Verify ownership if user is logged in
        if (Auth::check()) {
             $tripDetail = TripDetail::where('location_overview_id', $activity->itinerary->location_overview_id)->first();
             if (!$tripDetail || $tripDetail->user_id !== Auth::id()) {
                 return response()->json(['error' => 'Unauthorized'], 403);
             }
        }
        
        try {
            $location = $activity->itinerary->locationOverview->tripDetail->location ?? 'the destination';
            $prompt = TravelPlanPrompt::generateAlternatives($location, $activity->name);
            $apiKey = env('GOOGLE_GEN_AI_API_KEY');

            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$apiKey", [
                    'contents' => [['parts' => [['text' => $prompt]]]],
                ]);

            if (!$response->successful()) {
                throw new Exception('AI service failed: ' . $response->body());
            }

            $responseBody = $response->json();
            $generatedText = $responseBody['candidates'][0]['content']['parts'][0]['text'];
            $generatedText = preg_replace('/```json\s*|\s*```/', '', $generatedText);
            $alternatives = json_decode(trim($generatedText), true);

            return response()->json(['alternatives' => $alternatives]);

        } catch (Exception $e) {
            Log::error("Failed to get alternatives: " . $e->getMessage());
            return response()->json(['error' => 'Failed to generate suggestions'], 500);
        }
    }

    public function replaceActivity(Request $request, $id)
    {
        Log::info("replaceActivity called with ID: " . $id);
        
        $activity = Activity::find($id);

        if (!$activity) {
            Log::error("Activity with ID {$id} not found.");
            return response()->json(['error' => 'Activity not found'], 404);
        }

        // Verify ownership
        if (Auth::check()) {
           if (!$activity->itinerary) {
                Log::error("Activity {$activity->id} has no itinerary relation.");
                return response()->json(['error' => 'Activity data integrity error'], 500);
            }

           $tripDetail = TripDetail::where('location_overview_id', $activity->itinerary->location_overview_id)->first();
            
            if (!$tripDetail || $tripDetail->user_id !== Auth::id()) {
               Log::warning("Unauthorized replace attempt.");
               return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $request->validate([
            'name' => 'required|string',
            'location' => 'nullable|string', 
        ]);

        $updateData = [
            'name' => $request->input('name'),
            'image_url' => null, // Reset image to trigger new fetch
        ];

        // If enhanced data is provided (from AI suggestion), use it
        if ($request->has('description')) $updateData['description'] = $request->input('description');
        if ($request->has('cost')) $updateData['cost'] = $request->input('cost');
        if ($request->has('duration')) $updateData['duration'] = $request->input('duration');
        if ($request->has('best_time')) $updateData['best_time'] = $request->input('best_time');
        if ($request->has('fee')) $updateData['fee'] = $request->input('fee');
        if ($request->has('phone_number')) $updateData['phone_number'] = $request->input('phone_number');
        if ($request->has('website')) $updateData['website'] = $request->input('website');
        if ($request->has('address')) $updateData['address'] = $request->input('address');
        
        // Fallback or override address if location is specifically passed but not address
        if ($request->has('location') && !isset($updateData['address'])) {
             $updateData['address'] = $request->input('location');
        }

        // If no description provided, use default
        if (!isset($updateData['description'])) {
            $updateData['description'] = 'User added activity: ' . $updateData['name'];
        }

        $activity->update($updateData);

        return response()->json([
            'success' => true,
            'activity' => $activity
        ]);
    }

    public function getAddActivitySuggestions($itineraryId)
    {
        try {
            $itinerary = Itinerary::with('locationOverview')->findOrFail($itineraryId);
            
            if (!$itinerary->locationOverview) {
                 Log::error("Itinerary {$itineraryId} has no location overview.");
                 return response()->json(['error' => 'Location data missing'], 404);
            }

            $locationOverview = $itinerary->locationOverview;
            
            // Find the trip detail to get the location name
            $tripDetail = TripDetail::where('location_overview_id', $locationOverview->id)->first();
            
            if (!$tripDetail) {
                // Fallback if trip detail is missing but we have location overview
                // We might not have the location name easily if it's only in trip details?
                // Actually LocationOverview might not have the name string.
                // Let's try to get it from context or just return error.
                Log::error("Trip detail not found for location overview {$locationOverview->id}");
                return response()->json(['error' => 'Trip details not found'], 404);
            }

            $location = $tripDetail->location;
            
            // Generate prompt
            $prompt = \App\Prompts\TravelPlanPrompt::generateAddSuggestions($location);
            $apiKey = env('GOOGLE_GEN_AI_API_KEY');

            // Call Gemini directly
            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$apiKey", [
                    'contents' => [['parts' => [['text' => $prompt]]]],
                ]);

            if (!$response->successful()) {
                Log::error('AI service failed: ' . $response->body());
                return response()->json(['error' => 'AI service failed'], 500);
            }

            $responseBody = $response->json();
            $generatedText = $responseBody['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            // Clean up JSON
            $cleanResult = preg_replace('/```json\s*|\s*```/', '', $generatedText);
            $suggestions = json_decode(trim($cleanResult), true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON Decode Error: ' . json_last_error_msg());
                Log::error('Raw AI Response: ' . $generatedText);
                return response()->json(['error' => 'Failed to parse AI response'], 500);
            }
            
            return response()->json($suggestions);

        } catch (Exception $e) {
            Log::error('Error fetching add activity suggestions: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch suggestions'], 500);
        }
    }

    public function storeActivity(Request $request, $itineraryId)
    {
        try {
            $itinerary = Itinerary::findOrFail($itineraryId);
            
            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'cost' => 'nullable|string',
                'duration' => 'nullable|string',
                'best_time' => 'nullable|string',
                'address' => 'nullable|string',
                'fee' => 'nullable|string',
                'phone_number' => 'nullable|string',
                'website' => 'nullable|string',
            ]);

            // Fetch image if not provided
            $imageUrl = null;
            try {
                $imageUrl = GooglePlacesHelper::getPlacePhotoUrl($validated['name']);
                if (str_starts_with($imageUrl, 'Error:')) {
                    $imageUrl = null;
                }
            } catch (Exception $e) {
                Log::warning('Failed to fetch image for new activity', ['error' => $e->getMessage()]);
            }

            $activity = Activity::create([
                'itinerary_id' => $itinerary->id,
                'location_overview_id' => $itinerary->location_overview_id,
                'name' => $validated['name'],
                'description' => $validated['description'] ?? '',
                'coordinates' => '', // AI doesn't always give coords
                'address' => $validated['address'] ?? '',
                'cost' => $validated['cost'] ?? '',
                'duration' => $validated['duration'] ?? '',
                'best_time' => $validated['best_time'] ?? '',
                'phone_number' => $validated['phone_number'] ?? '',
                'website' => $validated['website'] ?? '',
                'fee' => $validated['fee'] ?? null,
                'image_url' => $imageUrl
            ]);

            return response()->json([
                'success' => true,
                'activity' => $activity
            ]);

        } catch (Exception $e) {
            Log::error('Error storing new activity: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to add activity'], 500);
        }
    }

    // Add this new method to show temporary travel plan
    public function showTemp()
    {
         $tempPlan = session('temp_travel_plan');
        if (!$tempPlan) {
            return redirect()->to('/')->with('error', 'Temporary travel plan not found.');
        }

        // Calculate check-in and check-out dates
        $startDate = Carbon::parse($tempPlan['created_at']);
        $checkInDate = $tempPlan['check_in_date'] ?? $startDate->format('Y-m-d');
        $checkOutDate = $tempPlan['check_out_date'] ?? $startDate->copy()->addDays($tempPlan['duration'])->format('Y-m-d');

        // Create trip details object
        $tripDetails = (object) [
            'reference_code' => $tempPlan['reference_code'],
            'location' => $tempPlan['location'],
            'duration' => $tempPlan['duration'],
            'traveler' => $tempPlan['traveler'],
            'budget' => $tempPlan['budget'],
            'activities' => $tempPlan['activities'],
            'google_place_image' => null
        ];

        // Get Google Places image for the location
        // Google Places image will be fetched by frontend
        $tripDetails->google_place_image = null;

        // Convert arrays to objects for consistent property access
        $locationOverview = (object) $tempPlan['plan']['location_overview'];
        $additionalInfo = (object) $tempPlan['plan']['additional_information'];
        $securityAdvice = (object) $tempPlan['plan']['location_overview']['security_advice'];
        
        // Handle emergency facilities
        if (isset($tempPlan['plan']['location_overview']['security_advice']['local_emergency_facilities'])) {
            $securityAdvice->emergency_facilities = collect($tempPlan['plan']['location_overview']['security_advice']['local_emergency_facilities'])
                ->map(function($facility) {
                    return (object) $facility;
                })->all();
        }

        // Handle transportation and dining costs
        if (isset($tempPlan['plan']['costs'][0])) {
            $costs = $tempPlan['plan']['costs'][0];
            $additionalInfo->transportation_costs = collect($costs['transportation'] ?? [])
                ->map(function($transport) {
                    return (object) $transport;
                })->all();
            
            $additionalInfo->dining_costs = collect($costs['dining'] ?? [])
                ->map(function($dining) {
                    return (object) $dining;
                })->all();
        }

        // Handle local cuisine
        if (isset($tempPlan['plan']['location_overview']['local_cuisine'])) {
            $additionalInfo->local_cuisine = (object) $tempPlan['plan']['location_overview']['local_cuisine'];
        }

        // Get hotels from Agoda with check-in and check-out dates
        $agodaHotels = $this->hotelRecommendationService->getHotelRecommendations(
            $tempPlan['location'], 
            $checkInDate, 
            $checkOutDate, 
            $tempPlan['budget']
        );
        
        // Get city ID for Agoda link
        $cityId = null;
        try {
            $suggestionResponse = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/91.0.4472.124 Safari/537.36',
                    'Accept' => 'application/json',
                ])->get('https://partners.agoda.com/HotelSuggest/GetSuggestions', [
                    'type' => 1,
                    'limit' => 10,
                    'term' => $tempPlan['location'],
                ]);

            if ($suggestionResponse->successful()) {
                $suggestions = $suggestionResponse->json();
                if (!empty($suggestions) && is_array($suggestions)) {
                    $cityId = $suggestions[0]['Value'] ?? null;
                }
            }
        } catch (Exception $e) {
            Log::warning('Failed to get city ID for Agoda link', [
                'location' => $tempPlan['location'],
                'error' => $e->getMessage()
            ]);
        }
        
        Log::info('Agoda hotel recommendations result', [
            'hotels' => $agodaHotels,
            'checkInDate' => $checkInDate,
            'checkOutDate' => $checkOutDate,
            'budget' => $tempPlan['budget'],
            'cityId' => $cityId
        ]);
        
        // Convert Agoda hotels to objects and store in session
        $hotels = [];
        if (!empty($agodaHotels)) {
            Log::info('Using Agoda hotel recommendations', ['count' => count($agodaHotels)]);
            
            // Store hotels in the format expected by GoogleController
            $tempPlan['plan']['agoda_hotels'] = $agodaHotels;
            
            // Convert to objects for view display
            $hotels = collect($agodaHotels)->map(function($hotel) {
                return (object) [
                    'name' => $hotel['name'],
                    'description' => $hotel['description'],
                    'address' => $hotel['address'],
                    'rating' => $hotel['rating'],
                    'price' => $hotel['price'],
                    'currency' => $hotel['currency'],
                    'image_url' => $hotel['image_url'],
                    'amenities' => (object) [
                        'free_wifi' => $hotel['amenities']['free_wifi'] ?? false,
                        'breakfast_included' => $hotel['amenities']['breakfast_included'] ?? false
                    ],
                    'location' => (object) [
                        'latitude' => $hotel['location']['latitude'],
                        'longitude' => $hotel['location']['longitude']
                    ],
                    'review_score' => $hotel['review_score'],
                    'review_count' => $hotel['review_count'],
                    'booking_url' => $hotel['booking_url']
                ];
            })->all();

            // Update the temp plan session
            session(['temp_travel_plan' => $tempPlan]);
        }

        // Convert itineraries to objects
        $itineraries = collect($tempPlan['plan']['itinerary'])->map(function($day) {
            $dayObj = (object) $day;
            $dayObj->activities = collect($day['activities'])->map(function($activity) {
                return (object) $activity;
            })->all();
            return $dayObj;
        })->all();

        // Get Google Places image for the itineraries
        // Google Places images for itineraries will be fetched by frontend
        foreach ($itineraries as $itinerary) {
            foreach ($itinerary->activities as $activity) {
                $activity->image_url = null;
            }
        }

        return view('pages.tempTravelResult', compact(
            'tripDetails',
            'locationOverview',
            'additionalInfo',
            'securityAdvice',
            'hotels',
            'itineraries',
            'cityId'
        ));
    }
}
