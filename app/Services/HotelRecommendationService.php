<?php

namespace App\Services;

use App\Http\Controllers\TravelPlanException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HotelRecommendationService
{
    private $agodaApiKey;
    private $agodaPartnerId;

    public function __construct()
    {
        $this->agodaApiKey = env('AGODA_API_KEY');
        $this->agodaPartnerId = env('AGODA_PARTNER_ID');
    }

    public function getHotelRecommendations($location, $checkInDate , $checkOutDate , $budget = null, $cityId = null)
    {
        try {
            Log::info('Getting hotel recommendations from Node API', [
                'location' => $location,
                'checkInDate' => $checkInDate,
                'checkOutDate' => $checkOutDate,
                'budget' => $budget,
                'cityId' => $cityId
            ]);

            $nodeAiUrl = env('NODE_AI_SERVICE_URL');

            $payload = json_encode([
                'location' => $location,
                'checkIn' => $checkInDate,
                'checkOut' => $checkOutDate,
                'budget' => $budget,
                'cityId' => $cityId
            ]);

            $options = [
                'http' => [
                    'header'  => "Content-Type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => $payload,
                    'timeout' => 30, // 30 seconds
                    'ignore_errors' => true,
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ]
            ];

            $context = stream_context_create($options);
            $result = @file_get_contents("{$nodeAiUrl}/api/hotels", false, $context);

            $statusCode = 500;
            if (isset($http_response_header) && count($http_response_header) > 0) {
                preg_match('{HTTP\/\S*\s(\d{3})}', $http_response_header[0], $match);
                if (isset($match[1])) {
                    $statusCode = (int) $match[1];
                }
            }

            if ($result === false || $statusCode < 200 || $statusCode >= 300) {
                $errorBody = $result ? $result : 'Connection Failed';
                Log::warning('Failed to get hotels from Node API', [
                    'status' => $statusCode,
                    'error' => $errorBody
                ]);
                return [];
            }

            $responseData = json_decode($result, true) ?: [];
            $formattedHotels = $responseData['hotels'] ?? [];

            if (empty($formattedHotels)) {
                Log::warning('No formatted hotels available from Node API');
                return [];
            }

            Log::info('Successfully retrieved hotel recommendations', [
                'count' => count($formattedHotels),
            ]);

            return $formattedHotels;
        } catch (\Exception $e) {
            Log::error('Error getting hotel recommendations', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'location' => $location,
                'budget' => $budget
            ]);
            return [];
        }
    }
} 