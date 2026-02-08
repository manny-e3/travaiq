<?php

namespace App\Services;

use App\Helpers\GooglePlacesHelper;
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

    public function getHotelRecommendations($location, $checkInDate , $checkOutDate , $budget = null)
    {
        try {
            Log::info('Getting hotel recommendations', [
                'location' => $location,
                'checkInDate' => $checkInDate,
                'checkOutDate' => $checkOutDate,
                'budget' => $budget
            ]);

            // Normalize and determine budget range
            $budget = strtolower(trim($budget));
            if ($budget === 'low') {
                $min = 30; $max = 1000;
            } elseif ($budget === 'medium') {
                $min = 100; $max = 3000;
            } elseif ($budget === 'high') {
                $min = 200; $max = 10000;
            } else {
                $min = 30; $max = 10000;
            }

            // Get hotels from Agoda
            $agodaHotels = $this->getAgodaHotels($location, $checkInDate, $checkOutDate, $min, $max);
           
            if ($agodaHotels === null) {
                Log::warning('No hotels found from Agoda', [
                    'location' => $location,
                    'budget' => $budget
                ]);
                return [];
            }

            // Format the hotels
            $formattedHotels = $this->formatAgodaHotels($agodaHotels);
            
            if (empty($formattedHotels)) {
                Log::warning('No formatted hotels available', [
                    'raw_data' => $agodaHotels
                ]);
                return [];
            }

            Log::info('Successfully retrieved hotel recommendations', [
                'count' => count($formattedHotels),
                'sample' => array_slice($formattedHotels, 0, 2)
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

    private function getAgodaHotels($location, $checkInDate, $checkOutDate, $min = 20, $max = 10000)
    {
        try {
            Log::info('Getting city suggestions from Agoda', [
                'location' => $location,
                'api_key' => $this->agodaApiKey ? 'present' : 'missing',
                'partner_id' => $this->agodaPartnerId ? 'present' : 'missing'
            ]);

            // Get city suggestions first with timeout
       

                  $suggestionResponse = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/91.0.4472.124 Safari/537.36',
                'Cookie' => 'agoda.user.03=UserId=1c4a4475-5aa5-4398-8128-420fb4ada197; agoda.prius=PriusID=0&PointsMaxTraffic=Agoda; agoda.version.03=CookieId=e7ee010c-c7a4-4449-a436-6509a77f3027&DLang=en-us&CurLabel=NGN; agoda.price.01=PriceView=1; FPID=FPID2.2.Utgqcr%2FZB6QOj%2FFmOTWrRRyiD37vbsYJcsBFQPQa1Eo%3D.1765575231; _fbp=fb.1.1765575243605.82654989758290810; t_pp=oTXRDw2gug/ZuAJu:4O7mll7vzUU3quyBN/i1Qg==:xkWekZGnfprvlueYmjKJHxuM7G23+AHkw5cQCjCLiS4W8BAKm7yaYiqEF2cSUPXGvJl8ITdhzP3gxK71bpNAN1r2c6hl7Vzbwz1Buo79Q5mmgO0e+96u+HWRc4kxo/K9FbmMYlZvFVWl6RcG4PonBDrwu0TImvIXHdDvECQIVFqz/5KZJTtQqKG8pHawEkIIiNgOhxl45dG/A5JFzBh/NyoFx3cntahdt98uiquwZx7ORw==; ASP.NET_SessionId=vlp1f0fh0dvowrgvsdfmzpsc; agoda.mse.01=%7B%22property%22%3A%5B%5D%2C%22activity%22%3A%5B%5D%7D; agoda.lastclicks=1922878||9c6545bc-1666-4ddf-9cd0-c70620f2972d||2025-12-29T15:59:07||vlp1f0fh0dvowrgvsdfmzpsc||{"IsPaid":true,"gclid":"Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB","Type":""}; agoda.attr.03=ATItems=-1$12-13-2025 04:32$|1922878$12-29-2025 15:59$9c6545bc-1666-4ddf-9cd0-c70620f2972d; agoda.landings=1922878|9c6545bc-1666-4ddf-9cd0-c70620f2972d||vlp1f0fh0dvowrgvsdfmzpsc|2025-12-29T15:59:06|True|19----1922878|9c6545bc-1666-4ddf-9cd0-c70620f2972d|Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB|vlp1f0fh0dvowrgvsdfmzpsc|2025-12-29T15:59:07|True|20----1922878|9c6545bc-1666-4ddf-9cd0-c70620f2972d|Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB|vlp1f0fh0dvowrgvsdfmzpsc|2025-12-29T15:59:07|True|99; tealiumEnable=true; utag_main=v_id:019b147bb1c900b059ab1d9c96400506f00160670093c$_sn:2$_se:1$_ss:1$_st:1767000549718$ses_id:1766998749718%3Bexp-session$_pn:1%3Bexp-session; agoda.consent=NG||2025-12-29 08:59:10Z; _gcl_aw=GCL.1766998751.Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB; __gads=ID=bb9ec13195ef35a8:T=1766998751:RT=1766998751:S=ALNI_MYbseiLyXksyUv6u0_kRZh3v3j2_A; __gpi=UID=000012bca2072489:T=1766998751:RT=1766998751:S=ALNI_MaM9blYv_8JdNibmrrCQ3ml1m1Qzw; _uetsid=a4ab88e0e49411f0bc921d2601d3fb99|1ibp5ln|2|g29|0|2189; _uetvid=42e300a0d7a211f0927499588b10ffeb|1jnq99i|1766998753874|2|1|bat.bing.com/p/conversions/c/z; _gid=GA1.2.194559772.1766998754; _gac_UA-6446424-30=1.1766998754.Cj0KCQiA6sjKBhCSARIsAJvYcpO8Vu6QYFM-Z0GQXQXgz5xV_q8rfmbpwy4gUgDKcXUVKaacSkwoeXYaAoyiEALw_wcB; _gcl_au=1.2.816925682.1765575227; _ga_C07L4VP9DZ=GS2.2.s1766998754$o2$g0$t1766998754$j60$l0$h0; _ga_T408Z268D2=GS2.1.s1766998751$o2$g1$t1766998755$j56$l0$h1200454160; agoda_ptnr_tracking=137949ec-3943-42b4-858c-2787abf1bed8; __RequestVerificationToken=ZcFIxhEqo7mBYz578JT1J1yvH_x23mB9NaLmJ6Kem9ztFgx_1wuB1bVE4tGHZnsJU77KHuJpWChjk7vYL8KGAwCx5YE1; cto_bundle=WR9T8l9SUnJGeHV5dmJYSnVwVG5udkQySDFWRllBblVUeWh5MVBQMmJXeDFpRHNacFlhODliQlJ3dWtNRm4lMkJadUhDVTc4bzRERXJrZWNUMUFJbVZaMiUyRjdzQ2JrMkthakdXdHpyZjBLMW9Ta3owYXBKV3dwN2hmS1k2MlN1VlJGeFhVVmIlMkJCM2Yzd3JEQVRMMnRSSGxEOFRUY3clM0QlM0Q; _ga_PJFPLJP2TM=GS2.1.s1766998778$o1$g0$t1766998778$j60$l0$h0; ai_user=UoEopTUTZVb6PMUq70Y79E|2025-12-29T08:59:38.232Z; ai_session=W2rYXkspG8qZroVYbz6llq|1766998778746|1766998778746; ul.session=ccf4bab7-f5b5-4478-bba8-b17113ac8cfe; xsrf_token=CfDJ8Dkuqwv-0VhLoFfD8dw7lYx22PONZpW430INVBPUVcix4bgm6jFZ79nBJqweylkPifiZcar2G7c9PQXD5jGwhgsmzXROYTQa24BkZmuQ2azuPWyk9ErHQeO-mOykenRWJ7H8vBmnjGcQQtH2nzU-bjk; ul.pc.token=eyJhbGciOiJFUzI1NiJ9.eyJtIjo0MjYzMDk5MjMsInIiOlsiMTI3XzM0ODM4NSJdLCJlIjoiPTd0JEAjVTluc0pASl9bW3RnPSskY3QjLD1MRVV1ckR1IzxRaXU8dCQ6VyFiNFldSDpAUlJQPF9FWiorKmthVUNfLmEmK0BacGBOSzFAPkQiLCJzcmMiOiJzcmMiLCJzdWIiOiJRaHJZakduZFJpR2lOVnFlbWFOVEl3IiwianRpIjoiZ1VGR0ZGOXlReHFKdXJKdEk2ZmNLZyIsImlhdCI6MTc2Njk5ODc4MywiZXhwIjoxNzc0Nzc0NzgzLCJ3bHQiOiJmMWE1OTA1Zi05NjIwLTQ1ZTUtOWQ5MS1kMjUxYzA3ZTBiNDIiLCJzIjoyfQ.OFYdiSc-NgJ8lEdAFumpvLXH3amvRosfUWdpzUHJ1gf_2NV5PKleg90eGuWebn742PEZjPPOlGpNy9uvBiSUuw; _ga=GA1.1.137797662.1765575231; _ga_80F3X70H1C=GS2.1.s1766998857$o1$g0$t1766998857$j60$l0$h0; agoda.analytics=Id=9196862786460344372&Signature=-3848233439802041329&Expiry=1798538622000; t_rc=t=43&8ETD+1m6XA3NQYm7DVQvpQ=1',
            'Accept' => 'application/json',
        ])->timeout(10) // Prevent long hangs
          ->retry(2, 200) // Retry on transient errors
          ->withOptions([
              'verify' => false, // use with caution, only for dev
              'curl' => [
                  CURLOPT_FOLLOWLOCATION => true,
              ],
          ])
          ->get('https://partners.agoda.com/HotelSuggest/GetSuggestions', [
              'type' => 1,
              'limit' => 10,
              'term' => $location,
          ]);

              

            Log::info('Agoda city suggestions response', [
                'status' => $suggestionResponse->status(),
                'body' => $suggestionResponse->body()
            ]);

            if (!$suggestionResponse->successful()) {
                Log::error('Failed to get city suggestions from Agoda', [
                    'status' => $suggestionResponse->status(),
                    'response' => $suggestionResponse->body()
                ]);
                return null;
            }

            $suggestions = $suggestionResponse->json();
             // dd($suggestionResponse);

            if (empty($suggestions) || !is_array($suggestions)) {
                Log::warning('No city suggestions found for location', [
                    'location' => $location,
                    'response' => $suggestions
                ]);
                return null;
            }

            $cityId = $suggestions[0]['Value'] ?? null;
          // dd($cityId);
            if (!$cityId) {
                Log::warning('City ID not found for location', [
                    'location' => $location,
                    'suggestions' => $suggestions
                ]);
                return null;
            }

            Log::info('Found city ID', ['cityId' => $cityId]);

            // Set default dates if not provided
            $checkInDate = $checkInDate ?? date('Y-m-d', strtotime('+7 days'));
            $checkOutDate = $checkOutDate ?? date('Y-m-d', strtotime('+12 days'));

            
            Log::info('Using budget range', [
                'min' => $min,
                'max' => $max
            ]);

            $hotelResponse = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept-Encoding' => 'gzip,deflate',
                    'Authorization' => $this->agodaPartnerId . ':' . $this->agodaApiKey,
                ])->post('http://affiliateapi7643.agoda.com/affiliateservice/lt_v1', [
                    'criteria' => [
                        'additional' => [
                            'currency' => 'USD',
                            'dailyRate' => [
                                'maximum' => $max,
                                'minimum' => $min
                            ],
                            'discountOnly' => false,
                            'language' => 'en-us',
                            'maxResult' => 20,
                            'minimumReviewScore' => 0,
                            'minimumStarRating' => 0,
                            'occupancy' => [
                                'numberOfAdult' => 2,
                                'numberOfChildren' => 1
                            ],
                            'sortBy' => 'PriceAsc'
                        ],
                        'checkInDate' => $checkInDate,
                        'checkOutDate' => $checkOutDate,
                        'cityId' => $cityId
                    ]
                ]);

           


            Log::info('Agoda hotels response', [
                'status' => $hotelResponse->status(),
                'body' => $hotelResponse->body()
            ]);

            if (!$hotelResponse->successful()) {
                Log::error('Failed to get hotels from Agoda', [
                    'status' => $hotelResponse->status(),
                    'response' => $hotelResponse->body()
                ]);

                
                return null;
            }

            $responseData = $hotelResponse->json();



           
        
            
            if (empty($responseData) || !isset($responseData['results'])) {
                Log::warning('No hotels found in Agoda response', [
                    'response' => $responseData
                ]);
                return null;
            }

            Log::info('Successfully retrieved hotels from Agoda', [
                'count' => count($responseData['results']),
                'sample' => array_slice($responseData['results'], 0, 2)
            ]);

            return $responseData;
        } catch (\Exception $e) {
            Log::error('Error in getAgodaHotels', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'location' => $location
            ]);
            return null;
        }
    }

    private function formatAgodaHotels($agodaHotels)
    {
        if ($agodaHotels === null) {
            Log::warning('Agoda hotels data is null');
            return [];
        }

        if (!is_array($agodaHotels) || !isset($agodaHotels['results'])) {
            Log::warning('Invalid Agoda hotels data format', [
                'data' => $agodaHotels
            ]);
            return [];
        }

        if (empty($agodaHotels['results'])) {
            Log::warning('No hotels found in Agoda response');
            return [];
        }

        $formattedHotels = [];
        $defaultImageUrl = 'https://img.freepik.com/premium-photo/hotel-room_1048944-29197645.jpg?w=900';
        
        foreach ($agodaHotels['results'] as $hotel) {
            try {
                $imageUrl = $hotel['imageURL'] ?? null;
                if (!$imageUrl) {
                    // Use default image instead of making API call
                    $imageUrl = $defaultImageUrl;
                }

                $formattedHotels[] = [
                    'name' => $hotel['hotelName'] ?? 'Unknown Hotel',
                    'description' => 'Hotel in ' . $hotel['hotelName'],
                    'address' => 'Address not available',
                    'rating' => $hotel['starRating'] ?? 0,
                    'price' => $hotel['dailyRate'] ?? 0,
                    'currency' => $hotel['currency'] ?? 'USD',
                    'image_url' => $imageUrl,
                    'amenities' => [
                        'free_wifi' => $hotel['freeWifi'] ?? false,
                        'breakfast_included' => $hotel['includeBreakfast'] ?? false
                    ],
                    'location' => [
                        'latitude' => $hotel['latitude'] ?? 0,
                        'longitude' => $hotel['longitude'] ?? 0
                    ],
                    'review_score' => $hotel['reviewScore'] ?? 0,
                    'review_count' => $hotel['reviewCount'] ?? 0,
                    'booking_url' => $hotel['landingURL'] ?? null
                ];
            } catch (\Exception $e) {
                Log::error('Error formatting hotel data', [
                    'error' => $e->getMessage(),
                    'hotel' => $hotel
                ]);
                continue;
            }
        }

        return $formattedHotels;
    }
} 