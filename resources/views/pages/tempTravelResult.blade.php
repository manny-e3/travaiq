@extends('layouts.app')

@section('title', $tripDetails->duration . ' Days in ' . $tripDetails->location . ' - Travaiq')

@section('content')

<!-- Hero Section -->
<div class="relative h-[50vh] min-h-[400px]">
    <img data-location="{{ $tripDetails->location }}" src="https://img.freepik.com/premium-photo/road-amidst-field-against-sky-sunset_1048944-19856354.jpg?w=1060" alt="{{ $tripDetails->location }}" class="w-full h-full object-cover lazy-image opacity-80 transition-opacity duration-700">
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
    <div class="absolute bottom-0 left-0 w-full p-8 md:p-12 text-white">
        <div class="container mx-auto">
            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold mb-3 border border-white/30">
                AI Generated Itinerary
            </span>
            <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight">{{ $tripDetails->duration }} Days in {{ $tripDetails->location }}</h1>
            <div class="flex flex-wrap gap-6 text-sm md:text-base opacity-90 font-medium">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ ucfirst($tripDetails->budget) }} Budget
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    {{ $tripDetails->traveler }}
                </div>
                <div class="flex items-center gap-2">
                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    {{ Str::limit(is_array($tripDetails->activities) ? implode(', ', $tripDetails->activities) : $tripDetails->activities, 40) }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12 relative z-10 -mt-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Content (Sidebar) -->
        <div class="lg:col-span-2 space-y-12">
            
            <!-- Trip Overview -->
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Trip</h2>
                <p class="text-gray-600 leading-relaxed mb-6">{{ $locationOverview->history_and_culture }}</p>
                
                <h3 class="text-lg font-bold text-gray-900 mb-3">Practical Information</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-gray-50 rounded-xl space-y-1">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Currency</span>
                        <p class="font-bold text-gray-800">{{ $additionalInfo->local_currency ?? 'N/A' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl space-y-1">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Timezone</span>
                        <p class="font-bold text-gray-800">{{ $additionalInfo->timezone ?? 'N/A' }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl space-y-1">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Language</span>
                        <p class="font-bold text-gray-800">English / Local</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl space-y-1">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Weather</span>
                        <p class="font-bold text-gray-800">{{ Str::limit(is_array($additionalInfo->weather_forecast ?? 'Varies') ? implode(', ', $additionalInfo->weather_forecast) : ($additionalInfo->weather_forecast ?? 'Varies'), 100) }}</p>
                    </div>
                </div>
            </div>

            <!-- Itinerary Timeline -->
           <div>
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Your Daily Plan</h2>
        <div class="flex gap-2">

         <!-- Edit Mode Toggle -->
                        <div class="flex items-center bg-gray-100 rounded-full p-1" id="edit-mode-container">
                            <span class="text-xs font-semibold px-3 text-gray-500">View</span>
                            <button onclick="openLoginModal('save_pdf')" id="edit-mode-btn" class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-300 transition-colors focus:outline-none">
                                <span class="sr-only">Enable edit mode</span>
                                <span id="edit-mode-knob" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-1"></span>
                            </button>
                            <span class="text-xs font-semibold px-3 text-gray-500">Edit</span>
                        </div>

            <button onclick="openLoginModal('save_pdf')" class="hidden md:flex px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors items-center gap-2 text-sm font-bold shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                PDF
            </button>
            <a href="https://www.getyourguide.com/s/?partner_id=8WZ0ASL&utm_medium=online_publisher&cmp=deal&q={{ $tripDetails->location }}"
            target="_blank"
            class="text-sm font-semibold text-primary hover:text-primary-dark transition-colors flex items-center px-4 py-2 bg-gray-50 rounded-xl">
                Explore Activities
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>

    <div class="space-y-6">
        @foreach ($itineraries as $itinerary)
            <div
                class="group relative pl-8 border-l-2 border-dashed border-gray-200 hover:border-primary transition-colors duration-300">

                <!-- Day Marker -->
                <div
                    class="absolute -left-[17px] top-0 w-8 h-8 rounded-full bg-white border-2 border-primary flex items-center justify-center font-bold text-xs text-primary shadow-sm group-hover:scale-110 transition-transform">
                    {{ $itinerary->day }}
                </div>

                <!-- Content Card -->
                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">

                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Day {{ $itinerary->day }}
                        <span class="text-sm font-normal text-gray-500 ml-2">
                            @if(isset($locationOverview->start_date))
                                {{ \Carbon\Carbon::parse($locationOverview->start_date)->addDays($itinerary->day - 1)->format('l, M jS') }}
                            @endif
                        </span>

                        
                    </h3>

                    <div class="space-y-6">
                        @foreach ($itinerary->activities as $activity)

                            <div class="flex flex-col sm:flex-row gap-6">

                                <div
                                    class="flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 relative group-hover:shadow-md transition-all"
                                    style="width: 18rem !important; height: 12rem !important;">
                                    <img
                                        data-location="{{ $activity->name }}"
                                        src="https://img.freepik.com/premium-photo/high-angle-view-smart-phone-table_1048944-29197645.jpg?w=900"
                                        alt="{{ $activity->name }}"
                                        class="w-full h-full object-cover grayscale opacity-60 lazy-image transition-all duration-700">

                                    <div
                                        class="absolute inset-0 flex items-center justify-center bg-gray-100/50 loading-spinner">
                                        <div
                                            class="w-5 h-5 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">

                                    <!-- FIXED ROW -->
                                    <div class="flex items-start gap-2">

                                        <div class="min-w-0">
                                            <!-- FIXED TITLE -->
                                            <h4 class="text-xl sm:text-base font-bold text-gray-900 break-words pr-2">
                                                {{ $activity->name }}
                                            </h4>

                                            <div class="flex flex-col sm:flex-row sm:items-center text-sm sm:text-xs text-gray-500 mb-2 mt-1 gap-1 sm:gap-0">
                                                <span class="mr-3 flex items-center">
                                                    <svg class="w-4 h-4 sm:w-3 sm:h-3 mr-1" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $activity->best_time }}
                                                </span>

                                                @if($activity->fee)
                                                    <span class="flex items-center text-green-600 font-medium sm:ml-3">
                                                        {{ $activity->fee }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- FIXED MAP BUTTON -->
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($activity->name . ' ' . $tripDetails->location) }}"
                                           target="_blank"
                                           class="ml-auto flex-shrink-0 p-2 bg-gray-50 rounded-full hover:bg-gray-100 text-gray-400 hover:text-primary transition-colors"
                                           title="View on map">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </a>

                                    </div>

                                    <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                                        {{ $activity->description }}
                                    </p>

                                    <div class="flex gap-2">
                                        @if($activity->website)
                                            <a href="{{ $activity->website }}"
                                               target="_blank"
                                               class="text-xs font-medium text-primary hover:underline">
                                                Website
                                            </a>
                                        @endif

                                        <a href="https://www.getyourguide.com/s/?partner_id=8WZ0ASL&q={{ urlencode($activity->name) }}"
                                           target="_blank"
                                           class="text-xs font-medium text-primary hover:underline">
                                            Book Ticket
                                        </a>
                                    </div>
                                    
                                    <div class="mt-3 pt-3 border-t border-gray-100 flex gap-2">
                                        <button onclick="openLoginModal('edit_activity')" class="flex-1 text-xs bg-gray-50 hover:bg-gray-100 text-gray-600 py-1.5 rounded border border-gray-200 transition-colors flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit
                                        </button>
                                    </div>

                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


            <!-- Getting There Section -->
            @if(isset($flightRecommendation))
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Getting There</h2>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    
                    <!-- Header with Origin/Destination -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 pb-6 border-b border-gray-100">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Recommended Flight Plan</p>
                            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-lg text-sm">✈️ Flights</span>
                                <span>to {{ $tripDetails->location }}</span>
                            </h3>
                        </div>
                        @if($flightRecommendation->best_booking_time)
                        <div class="mt-4 md:mt-0 px-4 py-2 bg-green-50 text-green-700 rounded-xl text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Best to book: {{ $flightRecommendation->best_booking_time }}
                        </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left: Airports & Airlines -->
                        <div class="space-y-6">
                            <div>
                                <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    Major Airports
                                </h4>
                                <ul class="space-y-3">
                                    @foreach($flightRecommendation->airports as $airport)
                                    <li class="flex items-center justify-between bg-gray-50 px-3 py-2 rounded-lg">
                                        <div>
                                            <span class="font-bold text-gray-800">{{ $airport->code }}</span>
                                            <span class="text-sm text-gray-600 ml-2">{{ $airport->name }}</span>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $airport->distance_to_city }} from city</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Recommended Airlines
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($flightRecommendation->airlines as $airline)
                                    <span class="px-3 py-1 bg-white border border-gray-200 rounded-full text-sm text-gray-700 shadow-sm">
                                        {{ $airline->name }} <span class="text-gray-400 text-xs ml-1">({{ $airline->typical_price_range }})</span>
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Right: Tips & Booking -->
                        <div class="space-y-6">
                            @if($flightRecommendation->travel_tips)
                            <div>
                                <h4 class="font-bold text-gray-900 mb-3">Expert Flight Tips</h4>
                                <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                                    <ul class="space-y-2">
                                        @foreach($flightRecommendation->travel_tips as $tip)
                                        <li class="flex items-start text-sm text-orange-900">
                                            <svg class="w-4 h-4 text-orange-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $tip }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            <div class="pt-2">
                                <h4 class="font-bold text-gray-900 mb-3">Compare Prices</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <a href="https://www.skyscanner.com/transport/flights-from/{{ strtolower(substr($flightRecommendation->airports->first()->code ?? 'any', 0, 3)) }}/{{ strtolower(substr($tripDetails->location, 0, 3)) }}" target="_blank" class="flex items-center justify-center py-2.5 px-4 bg-[#00a7e7]/10 text-[#00a7e7] hover:bg-[#00a7e7] hover:text-white rounded-xl font-bold transition-all text-sm group">
                                        Skyscanner
                                        <svg class="w-4 h-4 ml-1 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <a href="https://www.kayak.com/flights" target="_blank" class="flex items-center justify-center py-2.5 px-4 bg-[#ff690f]/10 text-[#ff690f] hover:bg-[#ff690f] hover:text-white rounded-xl font-bold transition-all text-sm group">
                                        Kayak
                                        <svg class="w-4 h-4 ml-1 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                                <p class="text-xs text-gray-400 mt-2 text-center">External links open in new tab</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Where to Stay -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Where to Stay</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($hotels as $hotel)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group hover:shadow-lg transition-all duration-300">
                        <div class="relative h-48 overflow-hidden">
                             @if (isset($hotel->image_url) && !empty($hotel->image_url))
                                <img src="{{ $hotel->image_url }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <img src="https://img.freepik.com/premium-photo/hotel-room_1048944-29197645.jpg?w=900" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-bold shadow-sm">
                                {{ number_format((float)($hotel->rating ?? 0), 1) }} ★
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 mb-1 line-clamp-1">{{ $hotel->name }}</h3>
                            <div class="flex items-end gap-1 mb-4">
                                <span class="text-lg font-bold text-primary">{{ $hotel->currency }} {{ number_format((float)$hotel->price, 0) }}</span>
                                <span class="text-xs text-gray-500 mb-1">/ night</span>
                            </div>
                            
                            @if(!empty($hotel->amenities))
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @php
                                        $amenities = $hotel->amenities;
                                        if (is_string($amenities)) {
                                            $amenities = json_decode($amenities, true);
                                        }
                                        if (is_object($amenities)) {
                                            $amenities = (array) $amenities;
                                        }
                                        if (!is_array($amenities)) {
                                            $amenities = [];
                                        }
                                    @endphp
                                    @foreach(collect($amenities)->take(3) as $key => $val)
                                        @if($val) 
                                            <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-1 bg-gray-50 text-gray-500 rounded-md">{{ str_replace('_', ' ', $key) }}</span> 
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                             <a href="{{ $hotel->booking_url ?? '#' }}" target="_blank" class="block w-full text-center py-2.5 rounded-xl bg-gray-900 text-white font-medium hover:bg-primary transition-colors text-sm">
                                View Deal
                             </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Right Sidebar (Sticky) -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                
                <!-- Action Card -->
                <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100">
                    <div class="mb-6">
                        <span class="font-semibold text-gray-800 text-sm">Total Estimated Cost</span>
                        
                       

                        <!-- Local Cuisine & Food -->
                        <div class="mt-6 border-t border-gray-100 pt-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <h4 class="font-semibold text-gray-800 text-sm">Local Cuisine & Food</h4>
                            </div>
                            <div class="space-y-2 ml-8">
                                @if (isset($additionalInfo->dining_costs))
                                    <div class="text-sm">
                                        <p class="font-medium text-gray-700 mb-1 text-xs uppercase tracking-wide">Avg. Prices</p>
                                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                                            @foreach($additionalInfo->dining_costs ?? [] as $cost)
                                                <li><span class="font-medium">{{ $cost->category ?? '' }}:</span> {{ $cost->cost_range ?? '' }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p class="text-gray-500 text-xs text-italic">No food information available</p>
                                @endif
                            </div>
                        </div>

                        <!-- Transportation Section -->
                        <div class="mt-4">
                            <div class="flex items-center gap-3 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                <h4 class="font-semibold text-gray-800 text-sm">Transportation</h4>
                            </div>
                            <div class="space-y-2 ml-8">
                                @if(isset($additionalInfo->transportation_options))
                                    <div class="mb-2">
                                        <p class="text-xs text-gray-600 leading-relaxed">{{ Str::limit(is_array($additionalInfo->transportation_options) ? implode(', ', $additionalInfo->transportation_options) : $additionalInfo->transportation_options, 100) }}</p>
                                    </div>
                                @endif
                                
                                @if(isset($additionalInfo->transportation_costs))
                                    <div class="text-sm">
                                         <p class="font-medium text-gray-700 mb-1 text-xs uppercase tracking-wide">Est. Fares</p>
                                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                                            @foreach($additionalInfo->transportation_costs ?? [] as $transport)
                                                <li><span class="font-medium">{{ $transport->type ?? '' }}:</span> {{ $transport->cost ?? '' }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                @if(!isset($additionalInfo->transportation_options) && !isset($additionalInfo->transportation_costs))
                                     <p class="text-gray-500 text-xs text-italic">No transportation info</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                         <a href="{{ route('loginRegister') }}" class="block w-full py-3 px-4 bg-primary text-white font-bold rounded-xl text-center shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                            Save This Trip
                        </a>
                        <button onclick="shareTrip()" class="block w-full py-3 px-4 bg-white border-2 border-gray-100 text-gray-700 font-bold rounded-xl text-center hover:border-gray-200 transition-colors">
                            Share Plan
                        </button>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-gray-100">
                         <a href="{{ route('createPlan') }}?destination={{ $tripDetails->location }}&customize=true" class="flex items-center justify-center text-sm font-medium text-gray-500 hover:text-primary transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            Customize Preferences
                        </a>
                    </div>
                </div>


                <!-- Safety Widget -->
                 <div class="bg-yellow-50 rounded-2xl p-6 border border-yellow-100">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <h3 class="font-bold text-yellow-800">Travel Advice</h3>
                    </div>
                    <div class="space-y-2 text-sm text-yellow-900/80">
                         <p><span class="font-semibold">Safety Score:</span> {{ $securityAdvice->overall_safety_rating ?? 'N/A' }}</p>
                         <p><span class="font-semibold">Emergency:</span> {{ $securityAdvice->emergency_numbers ?? '911' }}</p>
                    </div>
                    @php
                        $tips = $securityAdvice->safety_tips ?? [];
                        if (is_string($tips)) {
                            $tips = json_decode($tips, true);
                        }
                        if (is_object($tips)) {
                            $tips = (array) $tips;
                        }
                        if (!is_array($tips)) {
                            $tips = [];
                        }
                    @endphp
                    @if(count($tips) > 0)
                        <div class="mt-3 pt-3 border-t border-yellow-200/50">
                            <p class="text-xs text-yellow-800 mb-1 font-semibold">Top Tip:</p>
                            <p class="text-xs text-yellow-800 italic">"{{ $tips[0] }}"</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</div>

<div id="loginPromptModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeLoginModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Unlock Full Features
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                To <span id="modal-action-text">edit this activity</span>, you need to save your trip first. Create a free account to customize your itinerary, save your plans, and access them anytime!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <a href="{{ route('loginRegister') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:ml-3 sm:w-auto sm:text-sm">
                    Login / Register
                </a>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeLoginModal()">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function shareTrip() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $tripDetails->duration }} Days in {{ $tripDetails->location }}',
                text: 'Check out this itinerary I generated on Travaiq!',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Link copied to clipboard!');
        }
    }

    function openLoginModal(action) {
        const modal = document.getElementById('loginPromptModal');
        const actionText = document.getElementById('modal-action-text');
        
        if (action === 'save_pdf') {
            actionText.textContent = 'download the PDF';
        } else {
            actionText.textContent = 'edit this activity';
        }
        
        modal.classList.remove('hidden');
    }

    function closeLoginModal() {
        document.getElementById('loginPromptModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.lazy-image');
        
        const fetchImage = (img) => {
            const location = img.getAttribute('data-location');
            if (!location) return;

            fetch(`/api/place-image?location=${encodeURIComponent(location)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        img.src = data.url;
                        img.onload = () => {
                            img.classList.remove('grayscale', 'opacity-60', 'opacity-80');
                            const spinner = img.parentElement.querySelector('.loading-spinner');
                            if(spinner) spinner.remove();
                        };
                    } else {
                        const spinner = img.parentElement.querySelector('.loading-spinner');
                        if(spinner) spinner.remove();
                    }
                })
                .catch(err => {
                    console.error('Error fetching image:', err);
                    const spinner = img.parentElement.querySelector('.loading-spinner');
                    if(spinner) spinner.remove();
                });
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    fetchImage(entry.target);
                    // Add a small delay for visual cascading effect if multiple load at once
                    observer.unobserve(entry.target);
                }
            });
        }, { rootMargin: '100px' });

        images.forEach(img => observer.observe(img));
    });
</script>

@endsection