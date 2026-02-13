@extends('layouts.app')

@section('title', $trip->meta_title ?? $trip->location . ' Itinerary - ' . $trip->duration . ' Days')
@section('meta_description', $trip->meta_description ?? 'Explore this ' . $trip->duration . ' day itinerary for ' . $trip->location . '. Plan your perfect trip with Travaiq.')

@section('content')
<div class="relative">
    <!-- Hero Section -->
    <div class="relative h-[50vh] min-h-[400px] w-full overflow-hidden">
        @if($trip->google_place_image)
            <img src="{{ $trip->google_place_image }}" alt="{{ $trip->location }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
        @else
            <div class="w-full h-full bg-gray-900"></div>
        @endif
        
        <div class="absolute bottom-0 left-0 w-full p-8 md:p-12">
            <div class="container mx-auto drop-shadow-md">
                <div class="bg-black/30 backdrop-blur-md inline-block px-4 py-1 rounded-full text-white text-sm font-semibold mb-4 border border-white/20">
                    {{ $trip->duration }} Days Trip
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 drop-shadow-lg">{{ $trip->location }}</h1>
                <p class="text-white text-lg max-w-2xl drop-shadow-md font-medium">{{ $trip->meta_description ?? 'A curated travel itinerary for ' . $trip->location }}</p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Main Itinerary -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
                     <h2 class="text-2xl font-bold text-gray-900 mb-6">Trip Overview</h2>
                     <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                         <div class="p-4 bg-gray-50 rounded-2xl text-center">
                             <div class="text-2xl mb-2">💰</div>
                             <div class="text-sm text-gray-500">Budget</div>
                             <div class="font-bold text-gray-900">{{ $trip->budget }}</div>
                         </div>
                         <div class="p-4 bg-gray-50 rounded-2xl text-center">
                             <div class="text-2xl mb-2">👥</div>
                             <div class="text-sm text-gray-500">Travelers</div>
                             <div class="font-bold text-gray-900">{{ $trip->traveler }}</div>
                         </div>
                         <div class="p-4 bg-gray-50 rounded-2xl text-center">
                             <div class="text-2xl mb-2">🎭</div>
                             <div class="text-sm text-gray-500">Theme</div>
                             <div class="font-bold text-gray-900">{{ $trip->activities }}</div>
                         </div>
                          <div class="p-4 bg-gray-50 rounded-2xl text-center">
                             <div class="text-2xl mb-2">📅</div>
                             <div class="text-sm text-gray-500">Duration</div>
                             <div class="font-bold text-gray-900">{{ $trip->duration }} Days</div>
                         </div>
                     </div>
                </div>

                <div class="space-y-8">
                    <h2 class="text-2xl font-bold text-gray-900">Itinerary Details</h2>
                    
                    @if($trip->locationOverview && $trip->locationOverview->itineraries->count() > 0)
                        <div class="space-y-12 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-300 before:to-transparent">
                            @foreach($trip->locationOverview->itineraries as $itinerary)
                                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                                    <!-- Icon -->
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-100 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 text-gray-500 font-bold">
                                        {{ $itinerary->day }}
                                    </div>
                                    
                                    <!-- Card -->
                                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                                        <h3 class="font-bold text-lg text-gray-900 mb-3">Day {{ $itinerary->day }}</h3>
                                        <div class="space-y-4">
                                            @foreach($itinerary->activities as $activity)
                                                <div class="flex gap-4">
                                                    @if($activity->image_url)
                                                        <img src="{{ $activity->image_url }}" alt="{{ $activity->name }}" class="w-16 h-16 rounded-xl object-cover shrink-0">
                                                    @else
                                                        <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center shrink-0 text-2xl">📍</div>
                                                    @endif
                                                    <div>
                                                        <h4 class="font-bold text-gray-900 text-sm">{{ $activity->name }}</h4>
                                                        <p class="text-gray-500 text-xs line-clamp-2 mt-1">{{ $activity->description }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-3xl p-8 text-center">
                            <p class="text-gray-500">Full itinerary details are not available for this preview.</p>
                        </div>
                    @endif

                    <div class="bg-gradient-to-br from-primary/5 to-purple-50 rounded-3xl p-8 shadow-sm border border-primary/10 text-center relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Want to customize this trip?</h3>
                            <p class="text-gray-600 mb-6 max-w-lg mx-auto">Use this itinerary as a base and let our AI tailor it to your specific budget, dates, and preferences.</p>
                            
                            <form action="{{ route('travel.generate') }}" method="POST" class="inline-block">
                                @csrf
                                <input type="hidden" name="location" value="{{ $trip->location }}">
                                <input type="hidden" name="travel_date" value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}">
                                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary-dark transition-colors shadow-lg shadow-primary/30 transform hover:-translate-y-0.5 duration-200">
                                    Customize & Book This Trip
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-1/3">
                <div class="sticky top-8 space-y-6">
                    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-gray-200/50 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Like this trip?</h3>
                        <p class="text-gray-500 mb-6">Start planning your own adventure to {{ $trip->location }} based on this itinerary.</p>
                        
                        <a href="{{ route('createPlan', ['location' => $trip->location]) }}" class="block w-full text-center bg-gray-900 text-white py-3 rounded-xl font-bold hover:bg-gray-800 transition-colors mb-3">
                            Start Planning
                        </a>
                        
                         <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!');" class="block w-full text-center bg-gray-50 text-gray-900 py-3 rounded-xl font-bold hover:bg-gray-100 transition-colors border border-gray-200">
                            Share Trip
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
