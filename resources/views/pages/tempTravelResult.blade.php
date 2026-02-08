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
                    {{ Str::limit($tripDetails->activities, 40) }}
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
                        <p class="font-bold text-gray-800">{{ Str::limit($additionalInfo->weather_forecast ?? 'Varies', 100) }}</p>
                    </div>
                </div>
            </div>

            <!-- Itinerary Timeline -->
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Your Daily Plan</h2>
                    <a href="https://www.getyourguide.com/s/?partner_id=8WZ0ASL&utm_medium=online_publisher&cmp=deal&q={{ $tripDetails->location }}" target="_blank" class="text-sm font-semibold text-primary hover:text-primary-dark transition-colors flex items-center">
                        Explore Activities <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <div class="space-y-6">
                    @foreach ($itineraries as $itinerary)
                    <div class="group relative pl-4 sm:pl-8 border-l-2 border-dashed border-gray-200 hover:border-primary transition-colors duration-300">
                        <!-- Day Marker -->
                        <div class="absolute -left-[17px] top-0 w-8 h-8 rounded-full bg-white border-2 border-primary flex items-center justify-center font-bold text-xs text-primary shadow-sm group-hover:scale-110 transition-transform">
                            {{ $itinerary->day }}
                        </div>

                        <!-- Content Card -->
                        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Day {{ $itinerary->day }}
                                <span class="text-sm font-normal text-gray-500 ml-2">
                                    @if(isset($locationOverview->start_date))
                                        {{ \Carbon\Carbon::parse($locationOverview->start_date)->addDays($itinerary->day - 1)->format('l, M jS') }}
                                    @endif
                                </span>
                            </h3>

                            <div class="space-y-6">
                                @foreach ($itinerary->activities as $activity)
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <div class="w-full h-48 sm:w-24 sm:h-24 flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 relative group-hover:shadow-md transition-all">
                                        <img data-location="{{ $activity->name }}" src="https://img.freepik.com/premium-photo/high-angle-view-smart-phone-table_1048944-29197645.jpg?w=900" alt="{{ $activity->name }}" class="w-full h-full object-cover grayscale opacity-60 lazy-image transition-all duration-700">
                                         <div class="absolute inset-0 flex items-center justify-center bg-gray-100/50 loading-spinner">
                                            <div class="w-5 h-5 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-bold text-gray-900 break-words pr-4">{{ $activity->name }}</h4>
                                                <div class="flex items-center text-xs text-gray-500 mb-2 mt-1">
                                                    <span class="mr-3 flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $activity->best_time }}</span>
                                                    @if($activity->fee)<span class="flex items-center text-green-600 font-medium">{{ $activity->fee }}</span>@endif
                                                </div>
                                            </div>
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($activity->name . ' ' . $tripDetails->location) }}" target="_blank" class="p-2 bg-gray-50 rounded-full hover:bg-gray-100 text-gray-400 hover:text-primary transition-colors" title="View on map">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </a>
                                        </div>
                                        <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ $activity->description }}</p>
                                        <div class="flex gap-2">
                                            @if($activity->website)
                                                <a href="{{ $activity->website }}" target="_blank" class="text-xs font-medium text-primary hover:underline">Website</a>
                                            @endif
                                            <a href="https://www.getyourguide.com/s/?partner_id=8WZ0ASL&q={{ urlencode($activity->name) }}" target="_blank" class="text-xs font-medium text-primary hover:underline">Book Ticket</a>
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
                                    @foreach(collect($hotel->amenities)->take(3) as $key => $val)
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
                                        <p class="text-xs text-gray-600 leading-relaxed">{{ Str::limit($additionalInfo->transportation_options, 100) }}</p>
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
                    @if(isset($securityAdvice->safety_tips) && count($securityAdvice->safety_tips) > 0)
                        <div class="mt-3 pt-3 border-t border-yellow-200/50">
                            <p class="text-xs text-yellow-800 mb-1 font-semibold">Top Tip:</p>
                            <p class="text-xs text-yellow-800 italic">"{{ $securityAdvice->safety_tips[0] }}"</p>
                        </div>
                    @endif
                </div>

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