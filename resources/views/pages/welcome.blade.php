@extends('layouts.app')

@section('title', 'Travaiq — AI-Powered Travel Planning | Plan Your Dream Trip')

@section('content')

<!-- ==================== HERO SECTION ==================== -->
<section class="relative min-h-[92vh] flex items-center overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-indigo-50/40 to-purple-50/60"></div>
    <div class="blob-primary w-96 h-96 -top-24 -right-24 opacity-40 animate-pulse-slow"></div>
    <div class="blob-accent w-72 h-72 bottom-12 -left-20 opacity-30 animate-float-slow"></div>
    <div class="blob-primary w-48 h-48 top-1/2 right-1/3 opacity-20 animate-float"></div>

    <!-- Subtle Grid Pattern -->
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #7c3aed 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="container mx-auto px-4 py-12 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Left Content -->
            <div class="w-full lg:w-[55%] text-center lg:text-left">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-white/80 backdrop-blur-sm border border-gray-100 rounded-full shadow-sm mb-8 animate-fade-in-down">
                    <span class="flex h-2.5 w-2.5 relative mr-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    <span class="text-sm font-semibold text-gray-700">AI-Powered Travel Planning</span>
                    <span class="ml-2 text-xs bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold">FREE</span>
                </div>
                
                <!-- Headline -->
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 text-gray-900 tracking-tight leading-[1.1] animate-fade-in-up">
                    Your Next Adventure,<br>
                    <span class="text-gradient">Planned by AI</span>
                </h1>
                
                <!-- Subheadline -->
                <p class="text-lg md:text-xl text-gray-500 mb-10 leading-relaxed max-w-xl mx-auto lg:mx-0 animate-fade-in-up delay-200">
                    Tell us where you want to go, and our AI builds a personalized day-by-day itinerary with real hotels, hidden gems, and local experiences — in seconds.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-12 animate-fade-in-up delay-300">
                    <a href="{{ route('createPlan') }}" class="btn-primary-lg flex items-center gap-3 group">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Start Planning — It's Free
                    </a>
                    <a href="#how-it-works" class="btn-secondary flex items-center gap-2 group">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        See How It Works
                    </a>
                </div>

                <!-- Social Proof Bar -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6 animate-fade-in-up delay-400">
                    <div class="flex items-center bg-white/80 backdrop-blur-sm px-5 py-3 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex -space-x-3 mr-4">
                            <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://i.pravatar.cc/100?img=1" alt="Traveler" loading="lazy">
                            <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://i.pravatar.cc/100?img=5" alt="Traveler" loading="lazy">
                            <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://i.pravatar.cc/100?img=8" alt="Traveler" loading="lazy">
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-primary/10 flex items-center justify-center text-xs font-bold text-primary shadow-sm">+2k</div>
                        </div>
                        <div class="text-left">
                            <p class="text-lg font-extrabold text-gray-900">10,000+</p>
                            <p class="text-xs text-gray-500 font-medium">Trips Planned</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-amber-500">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                        <span class="text-sm text-gray-500 ml-1 font-medium">4.9/5 rating</span>
                    </div>
                </div>
            </div>

            <!-- Right: Quick Search Card -->
            <div class="w-full lg:w-[45%] animate-fade-in-right delay-300">
                <div class="relative max-w-md mx-auto">
                    <!-- Glow effect behind card -->
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-primary/30 via-accent/20 to-primary-light/30 rounded-3xl blur-xl opacity-60 animate-glow"></div>
                    
                    <div class="glass-card p-8 relative">
                        <div class="mb-7">
                            <h2 class="text-2xl font-bold text-gray-900">Where to next?</h2>
                            <p class="text-gray-500 text-sm mt-1">Plan your perfect trip in seconds</p>
                        </div>

                        <form action="{{ route('createPlan') }}" method="GET" class="space-y-5">
                            <!-- Origin -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Origin <span class="text-gray-400 font-normal">(Optional)</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="origin" name="origin"
                                        class="input-with-icon"
                                        placeholder="e.g. New York, London"
                                        autocomplete="off">
                                    <div id="origin-suggestions" class="suggestion-dropdown d-none"></div>
                                </div>
                            </div>
                            
                            <!-- Destination -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Destination</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="location" name="location" required
                                        class="input-with-icon"
                                        placeholder="e.g. Paris, Tokyo, Bali"
                                        autocomplete="off">
                                    <input type="hidden" id="city_id" name="city_id" value="">
                                    <div id="suggestions" class="suggestion-dropdown d-none"></div>
                                </div>
                            </div>

                            <!-- Travel Date -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Travel Date</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="date" name="travel_date" required
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                        class="input-with-icon">
                                </div>
                            </div>

                            <button type="submit" id="hero-create-btn" class="w-full btn-primary-lg flex items-center justify-center gap-2 group">
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Create My Itinerary
                            </button>
                        </form>

                        <div class="mt-5 flex items-center justify-center gap-5 text-xs text-gray-400">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                100% Free
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                No signup needed
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                AI-powered
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom fade -->
    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
</section>


<!-- ==================== TRUSTED BY / PARTNERS ==================== -->
<section class="py-10 bg-white border-b border-gray-100 relative z-10">
    <div class="container mx-auto px-4">
        <p class="text-center text-xs font-semibold text-gray-400 uppercase tracking-widest mb-6">Powered by world-class travel services</p>
        <div class="flex flex-wrap items-center justify-center gap-8 md:gap-14 opacity-40 grayscale hover:grayscale-0 hover:opacity-70 transition-all duration-500">
            <!-- Partner logos as SVG text placeholders -->
            <div class="flex items-center gap-2 text-gray-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                <span class="font-bold text-lg">Google</span>
            </div>
            <div class="flex items-center gap-2 text-gray-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z"/></svg>
                <span class="font-bold text-lg">Agoda</span>
            </div>
            <div class="flex items-center gap-2 text-gray-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 275 228">
                    <path d="M 0.09 157.75 L 0.00 224.17 L 0.05 114.00 L 0.08 35.42 L 0.15 68.50 L 2.38 60.50 C5.31,50.00 8.02,44.13 13.48,36.48 C28.43,15.52 54.77,3.13 88.08,1.37 C141.53,-1.44 182.77,26.47 187.54,68.69 C188.19,74.43 188.12,74.74 185.86,75.34 C181.36,76.55 161.31,76.08 160.25,74.75 C159.70,74.06 158.96,71.47 158.60,68.99 C157.80,63.43 153.98,55.03 149.94,49.93 C146.35,45.40 135.51,37.95 128.48,35.20 C116.12,30.36 97.98,28.27 83.00,29.97 C58.35,32.75 41.11,42.76 33.25,58.83 C29.53,66.43 29.50,66.61 29.56,78.50 C29.64,93.55 32.20,104.56 38.87,118.52 C47.60,136.80 58.50,151.29 80.19,173.49 L 93.87 187.50 L 101.01 180.50 C117.51,164.32 134.72,143.46 143.21,129.33 C143.93,128.13 144.61,127.05 145.22,126.09 C147.25,122.86 148.47,120.91 147.95,119.72 C147.16,117.91 142.29,117.89 129.98,117.82 C127.58,117.81 124.89,117.80 121.89,117.77 L 94.58 117.50 L 92.71 111.50 C91.68,108.20 90.26,102.01 89.56,97.75 L 88.28 90.00 L 137.64 90.00 C171.21,90.00 187.00,90.33 187.00,91.04 C187.00,94.18 183.48,108.31 180.83,115.83 C174.45,133.89 162.79,153.35 146.87,172.50 C142.30,178.00 128.59,192.59 116.42,204.93 L 94.28 227.36 L 75.99 209.43 C27.89,162.27 9.98,135.41 2.61,99.37 L 0.18 87.50 Z" />
                    <path d="M 231.01 175.50 C226.90,180.45 214.07,194.06 202.52,205.74 C182.55,225.92 181.40,226.91 179.50,225.47 C175.42,222.37 144.00,190.59 144.00,189.55 C144.00,188.96 145.01,187.35 146.25,185.97 C150.94,180.74 155.60,175.24 158.40,171.64 L 161.30 167.90 L 170.48 177.45 C175.52,182.70 180.11,187.00 180.67,187.00 C182.77,187.00 209.90,157.76 219.18,145.50 C226.87,135.34 236.00,120.47 236.00,118.11 C236.00,117.51 227.36,117.10 213.30,117.04 C200.82,116.98 190.45,116.78 190.25,116.59 C190.06,116.39 190.87,112.47 192.06,107.87 C193.25,103.26 194.51,97.25 194.86,94.50 L 195.50 89.50 L 234.75 89.24 C265.82,89.03 274.00,89.24 273.99,90.24 C273.95,93.91 269.80,110.60 267.07,118.09 C263.28,128.45 254.18,145.05 245.84,156.84 C242.46,161.60 239.43,165.73 239.10,166.00 C238.77,166.27 235.13,170.55 231.01,175.50 ZM 274.58 69.75 L 275.26 75.00 L 261.19 75.00 C253.45,75.00 246.92,74.66 246.69,74.25 C246.45,73.84 245.96,71.44 245.59,68.93 C242.54,47.83 218.83,31.32 188.75,29.34 C183.39,28.99 179.00,28.39 179.00,28.02 C179.00,25.32 156.64,7.00 153.34,7.00 C152.60,7.00 152.00,6.39 152.00,5.64 C152.00,2.22 181.51,-0.18 197.40,1.93 C222.31,5.25 239.32,13.13 254.53,28.42 C266.75,40.71 272.29,52.13 274.58,69.75 Z" />
                </svg>
                <span class="font-bold text-lg">Gowithguide</span>
            </div>
            <div class="flex items-center gap-2 text-gray-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                <span class="font-bold text-lg">Google Maps</span>
            </div>
        </div>
    </div>
</section>




<!-- ==================== RECENT ITINERARIES ==================== -->
@if(isset($exampleTrips) && $exampleTrips->count() > 0)
<section class="section-padding bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 reveal">
            <span class="badge-accent mb-4">✈️ Real Trips</span>
            <h2 class="section-heading">Recently Planned Adventures</h2>
            <p class="section-subheading">See what other travelers are planning and get inspired for your next trip.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($exampleTrips as $index => $trip)
            <a href="{{ route('public.trip.show', ['reference' => $trip->reference_code, 'location' => \Illuminate\Support\Str::slug($trip->location)]) }}" 
               class="card-destination border border-gray-100 reveal delay-{{ ($index + 1) * 200 }}">
                <div class="p-6">
                    <div class="flex justify-between items-start gap-4 mb-2">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $trip->location }}</h3>
                        <span class="flex-shrink-0 bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                            {{ $trip->duration }} Days
                        </span>
                    </div>
                    <p class="text-gray-500 line-clamp-2 text-sm mb-4">{{ $trip->meta_description ?? 'Explore this amazing AI-generated itinerary for ' . $trip->location }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-primary font-semibold text-sm group-hover:gap-2 transition-all">
                            View Itinerary 
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                        @if($trip->budget)
                        <span class="text-xs text-gray-400 font-medium">{{ $trip->budget }} Budget</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-12 reveal">
            <a href="{{ route('public.trip.index') }}" class="btn-secondary inline-flex items-center gap-2">
                View All Itineraries
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
@endif


<!-- ==================== FEATURES BENTO GRID ==================== -->
<section class="section-padding bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 reveal">
            <span class="badge-primary mb-4">Why TravaIQ</span>
            <h2 class="section-heading">More Than Just a Planner</h2>
            <p class="section-subheading">Experience the future of travel with intelligent features that go beyond basic itineraries.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            <!-- AI Personalization (large) -->
            <div class="md:col-span-2 card-feature min-h-[280px] reveal delay-100">
                <div class="blob-primary w-48 h-48 -top-12 -right-12 opacity-30"></div>
                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-gradient-to-br from-primary/10 to-primary/5 rounded-2xl flex items-center justify-center text-3xl mb-5">
                            🧠
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Smart AI Personalization</h3>
                        <p class="text-gray-500 max-w-md leading-relaxed">Our AI analyzes your travel style, budget, and interests to build unique itineraries. No two trips are the same — each plan is crafted just for you.</p>
                    </div>
                    <div class="mt-6 flex gap-3">
                        <span class="px-3 py-1.5 bg-primary/5 text-primary text-xs font-semibold rounded-full">Budget-aware</span>
                        <span class="px-3 py-1.5 bg-primary/5 text-primary text-xs font-semibold rounded-full">Style-matched</span>
                        <span class="px-3 py-1.5 bg-primary/5 text-primary text-xs font-semibold rounded-full">Real-time data</span>
                    </div>
                </div>
            </div>

            <!-- Instant Results -->
            <div class="card-feature min-h-[280px] reveal delay-200">
                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-3xl mb-5">⚡</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Instant Results</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Get a complete day-by-day plan in seconds. Stop wasting hours comparing travel blogs and reviews.</p>
                <div class="mt-auto pt-6">
                    <div class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                        Average: 30 seconds
                    </div>
                </div>
            </div>

            <!-- Real Hotels -->
            <div class="card-feature min-h-[280px] reveal delay-300">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-3xl mb-5">🏨</div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Real Hotel Deals</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Browse actual hotel availability with real-time pricing, ratings, and direct booking links from Agoda.</p>
                <div class="mt-auto pt-6">
                    <div class="flex items-center gap-2 text-sm text-emerald-600 font-medium">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Live prices & availability
                    </div>
                </div>
            </div>

            <!-- Export & Share (wide dark) -->
            <div class="md:col-span-2 rounded-3xl p-8 relative overflow-hidden min-h-[280px] reveal delay-400 bg-gradient-to-br from-gray-900 via-gray-800 to-primary-dark">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 24px 24px;"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-8 h-full">
                    <div class="flex-1">
                        <div class="inline-block px-3 py-1 bg-white/10 rounded-full text-xs font-bold text-white/70 mb-5 backdrop-blur-sm">✨ FEATURES</div>
                        <h3 class="text-2xl font-bold text-white mb-3">Export, Share & Customize</h3>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-md">Download your itinerary as a beautiful PDF, share it with friends via link, or customize activities to match your mood.</p>
                        <div class="flex flex-wrap gap-3 mt-5">
                            <span class="px-3 py-1.5 bg-white/10 text-white/80 text-xs font-semibold rounded-full backdrop-blur-sm">📄 PDF Export</span>
                            <span class="px-3 py-1.5 bg-white/10 text-white/80 text-xs font-semibold rounded-full backdrop-blur-sm">🔗 Shareable Links</span>
                            <span class="px-3 py-1.5 bg-white/10 text-white/80 text-xs font-semibold rounded-full backdrop-blur-sm">✏️ Editable Plans</span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('createPlan') }}" class="bg-white text-gray-900 px-7 py-3 rounded-full font-bold text-sm hover:bg-gray-100 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 inline-flex items-center gap-2">
                            Try It Now
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ==================== STATS SECTION ==================== -->
<section class="py-16 bg-gradient-to-r from-primary via-primary-dark to-indigo-700 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 30px 30px;"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
            <div class="stat-card reveal">
                <p class="text-4xl lg:text-5xl font-extrabold text-white" data-count="10000">10,000+</p>
                <p class="text-sm text-white/60 mt-2 font-medium">Trips Planned</p>
            </div>
            <div class="stat-card reveal delay-100">
                <p class="text-4xl lg:text-5xl font-extrabold text-white" data-count="150">150+</p>
                <p class="text-sm text-white/60 mt-2 font-medium">Countries Covered</p>
            </div>
            <div class="stat-card reveal delay-200">
                <p class="text-4xl lg:text-5xl font-extrabold text-white">4.9</p>
                <p class="text-sm text-white/60 mt-2 font-medium">User Rating</p>
            </div>
            <div class="stat-card reveal delay-300">
                <p class="text-4xl lg:text-5xl font-extrabold text-white">30s</p>
                <p class="text-sm text-white/60 mt-2 font-medium">Avg. Plan Time</p>
            </div>
        </div>
    </div>
</section>


<!-- ==================== TESTIMONIALS ==================== -->
<section class="section-padding bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 reveal">
            <span class="badge-success mb-4">💬 Testimonials</span>
            <h2 class="section-heading">Loved by Travelers</h2>
            <p class="section-subheading">See what real travelers say about their TravaIQ experience.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @foreach([
                ['name' => 'Sarah M.', 'location' => 'New York, USA', 'text' => 'TravaIQ planned my entire Tokyo trip in 30 seconds. The hotel recommendations were spot-on and the local gems it suggested were incredible!', 'img' => 'https://i.pravatar.cc/100?img=5', 'rating' => 5],
                ['name' => 'James L.', 'location' => 'London, UK', 'text' => 'I used to spend days planning trips. Now I just tell TravaIQ where I want to go, and it handles everything. The day-by-day itinerary is so detailed.', 'img' => 'https://i.pravatar.cc/100?img=12', 'rating' => 5],
                ['name' => 'Maria C.', 'location' => 'São Paulo, BR', 'text' => 'What I love most is that it shows real hotel prices and availability. No fake recommendations — everything is bookable and within my budget.', 'img' => 'https://i.pravatar.cc/100?img=9', 'rating' => 5]
            ] as $index => $testimonial)
            <div class="testimonial-card reveal delay-{{ ($index + 1) * 200 }}">
                <!-- Quote icon -->
                <svg class="w-8 h-8 text-primary/20 mb-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11H10v10H0z"/>
                </svg>
                <!-- Stars -->
                <div class="flex items-center gap-0.5 mb-3">
                    @for($i = 0; $i < $testimonial['rating']; $i++)
                    <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed mb-6">{{ $testimonial['text'] }}</p>
                <div class="flex items-center gap-3">
                    <img class="w-10 h-10 rounded-full border-2 border-gray-100" src="{{ $testimonial['img'] }}" alt="{{ $testimonial['name'] }}" loading="lazy">
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $testimonial['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $testimonial['location'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ==================== FAQ SECTION ==================== -->
<section class="section-padding bg-white">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="text-center mb-16 reveal">
            <span class="badge-primary mb-4">FAQ</span>
            <h2 class="section-heading">Common Questions</h2>
        </div>

        <div class="space-y-4 reveal" x-data="{ active: null }">
            @foreach([
                ['q' => 'Is TravaIQ really free?', 'a' => 'Absolutely! TravaIQ is 100% free to use. Generate as many itineraries as you want — no hidden costs, no credit card required, no catches.'],
                ['q' => 'How does the AI generate itineraries?', 'a' => 'We use Google\'s Gemini AI to analyze your destination, budget, travel style, and preferences. It then creates a day-by-day plan with real activities, restaurants, and hotels tailored specifically for you.'],
                ['q' => 'Are the hotel recommendations real?', 'a' => 'Yes! We integrate directly with Agoda to show you real hotels with actual pricing, ratings, reviews, and direct booking links. No fake or placeholder hotels.'],
                ['q' => 'Can I customize the generated plan?', 'a' => 'Absolutely. Once the AI generates your plan, you can edit, remove, or swap any activity. You can also add new activities and rearrange your itinerary however you like.'],
                ['q' => 'Do I need an account?', 'a' => 'No account is required to generate a plan. However, creating a free account allows you to save your trips, access them from any device, and share them with friends.'],
                ['q' => 'Can I download my itinerary?', 'a' => 'Yes! You can export your complete itinerary as a beautiful PDF document, perfect for printing or offline access during your trip.']
            ] as $index => $faq)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden transition-all duration-300" 
                 :class="active === {{ $index }} ? 'shadow-lg border-primary/30 ring-1 ring-primary/10' : 'hover:border-gray-300'">
                <button @click="active === {{ $index }} ? active = null : active = {{ $index }}" 
                        class="w-full flex items-center justify-between p-6 text-left focus:outline-none group">
                    <span class="font-semibold text-gray-900 group-hover:text-primary transition-colors">{{ $faq['q'] }}</span>
                    <span class="transition-transform duration-300 ml-4 flex-shrink-0" :class="active === {{ $index }} ? 'rotate-180' : ''">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div x-show="active === {{ $index }}" x-collapse class="px-6 pb-6 text-gray-500 text-sm leading-relaxed border-t border-gray-50 pt-4">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- ==================== FINAL CTA ==================== -->
<section class="py-24 bg-gradient-to-br from-gray-900 via-gray-800 to-primary-dark relative overflow-hidden">
    <div class="blob-primary w-96 h-96 -top-32 -left-32 opacity-30"></div>
    <div class="blob-accent w-72 h-72 bottom-0 right-0 opacity-20"></div>
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.3) 1px, transparent 0); background-size: 30px 30px;"></div>
    
    <div class="container mx-auto px-4 text-center relative z-10 reveal">
        <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 tracking-tight">
            Ready to Plan Your<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-light to-accent">Next Adventure?</span>
        </h2>
        <p class="text-lg text-gray-400 max-w-xl mx-auto mb-10">
            Join thousands of smart travelers who let AI handle the planning. Free, fast, and personalized — always.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('createPlan') }}" class="bg-white text-gray-900 px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl inline-flex items-center gap-3">
                <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Start Planning for Free
            </a>
            <a href="{{ route('travel.guide') }}" class="text-white/70 hover:text-white px-6 py-4 font-medium transition-colors inline-flex items-center gap-2">
                Explore Travel Guides
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Alpine.js CDN -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection

@guest
<!-- Google One Tap -->
<script src="https://accounts.google.com/gsi/client" async defer></script>
<div id="g_id_onload"
     data-client_id="{{ config('services.google.client_id') }}"
     data-callback="handleCredentialResponse"
     data-auto_prompt="true">
</div>
<script>
    function handleCredentialResponse(response) {
        fetch('/google-onetap-login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ credential: response.credential })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) { window.location.reload(); }
        })
        .catch(console.error);
    }
</script>
@endguest

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Wake up Node.js API (Render Free Tier)
        fetch('{{ env('NODE_AI_SERVICE_URL') }}/').catch(() => {});

        function setupLocationSearch(inputId, suggestionsId) {
            let searchTimeout;
            const $locationInput = $(inputId);
            const $suggestionsContainer = $(suggestionsId);

            $locationInput.on('input', function() {
                const searchTerm = $(this).val().trim();
                clearTimeout(searchTimeout);

                if (inputId === '#location') {
                    $('#city_id').val('');
                }

                if (searchTerm.length < 2) {
                    $suggestionsContainer.removeClass('show').addClass('d-none');
                    return;
                }

                $suggestionsContainer
                    .html(`
                        <div class="suggestion-item animate-pulse text-gray-400" role="option">
                            <svg class="w-4 h-4 animate-spin text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            <span>Searching...</span>
                        </div>
                    `)
                    .removeClass('d-none').addClass('show');

                searchTimeout = setTimeout(() => {
                    $.get('{{ env('NODE_AI_SERVICE_URL') }}/api/search', { term: searchTerm })
                        .done(function(response) {
                            if (response && response.length > 0) {
                                let suggestionsHtml = '';
                                response.forEach(function(suggestion) {
                                    suggestionsHtml += `<div class="suggestion-item" role="option" data-city-id="${suggestion.Value || ''}">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        <span>${suggestion.DisplayText}</span>
                                    </div>`;
                                });
                                $suggestionsContainer.html(suggestionsHtml).removeClass('d-none').addClass('show');
                            } else {
                                $suggestionsContainer.html('<div class="suggestion-item text-gray-400" role="option"><span>No results found</span></div>').addClass('show');
                            }
                        })
                        .fail(function() {
                            $suggestionsContainer.html('<div class="suggestion-item text-red-400" role="option"><span>Error loading suggestions</span></div>').addClass('show');
                        });
                }, 300);
            });

            $suggestionsContainer.on('click', '.suggestion-item', function() {
                const text = $(this).find('span').text();
                $locationInput.val(text);
                
                const cityId = $(this).data('city-id');
                if (cityId && inputId === '#location') {
                    $('#city_id').val(cityId);
                }
                
                $suggestionsContainer.removeClass('show').addClass('d-none');
            });

            const $wrapper = $locationInput.closest('.group');
            $(document).on('click', function(e) {
                if (!$(e.target).closest($wrapper).length) {
                    $suggestionsContainer.removeClass('show').addClass('d-none');
                }
            });
        }

        setupLocationSearch('#location', '#suggestions');
        setupLocationSearch('#origin', '#origin-suggestions');
    });

    // ========== Scroll Reveal (IntersectionObserver) ==========
    document.addEventListener('DOMContentLoaded', () => {
        const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        reveals.forEach(el => observer.observe(el));
    });
</script>