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
                            
                            <form id="customize-form" action="{{ route('travel.generate') }}" method="POST" class="inline-block">
                                @csrf
                                <input type="hidden" name="location" value="{{ $trip->location }}">
                                <input type="hidden" name="travel" value="{{ \Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}">
                                <input type="hidden" name="duration" value="{{ $trip->duration }}">
                                <input type="hidden" name="budget" value="{{ $trip->budget }}">
                                <input type="hidden" name="traveler" value="{{ $trip->traveler }}">
                                <input type="hidden" name="activities" value="{{ json_encode(array_map('trim', explode(',', $trip->activities))) }}">
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
<!-- Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 bg-white/90 z-50 hidden flex items-center justify-center backdrop-blur-md">
    <div class="text-center max-w-md px-8 animate__animated animate__fadeInUp">
        <div class="relative w-24 h-24 mx-auto mb-8">
            <div class="absolute inset-0 border-4 border-gray-200 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-primary rounded-full border-t-transparent animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
        </div>
        
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Designing Your Trip</h3>
        <p class="text-gray-500 mb-6" id="progressStatus">Analyzing preferences...</p>
        
        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden mb-2">
            <div class="h-full bg-primary rounded-full transition-all duration-500 ease-out" id="progressBar" style="width: 0%"></div>
        </div>
        <p class="text-sm font-medium text-primary mt-2" id="progressCounter">0%</p>
    </div>
</div>

<script>
    document.getElementById('customize-form').addEventListener('submit', function() {
        document.getElementById('loading-overlay').classList.remove('hidden');
        startProgress();
    });

    function startProgress() {
        let progress = 0;
        const progressBar = document.getElementById('progressBar');
        const progressCounter = document.getElementById('progressCounter');
        const progressStatus = document.getElementById('progressStatus');
        
        const stages = [
            { p: 15, t: 'Analyzing location...' },
            { p: 30, t: 'Checking weather patterns...' },
            { p: 50, t: 'Finding hidden gems...' },
            { p: 70, t: 'Curating attractions...' },
            { p: 90, t: 'Finalizing your plan...' }
        ];
        
        let stageIdx = 0;
        const interval = setInterval(() => {
            if (progress < 95) {
                progress += Math.random() * 2;
                if (progress > 95) progress = 95;
                
                progressBar.style.width = `${progress}%`;
                progressCounter.innerText = `${Math.floor(progress)}%`;
                
                if (stageIdx < stages.length && progress > stages[stageIdx].p) {
                    progressStatus.innerText = stages[stageIdx].t;
                    stageIdx++;
                }
            } else {
                clearInterval(interval);
            }
        }, 100);
    }
</script>
@endsection
