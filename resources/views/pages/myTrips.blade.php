@extends('layouts.app')

@section('title', 'Dashboard - TravaiQ')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 bg-gray-50/50 min-h-screen pb-16" x-data="{
        activeTab: 'my-trips',
        searchQuery: '',
        showOnboarding: {{ count($trips) === 0 ? 'true' : 'false' }},
        onboardingStep: 1,
        toasts: [],
        trips: [
            @foreach($trips as $trip)
            {
                id: {{ $trip->id }},
                location: '{{ addslashes($trip->location) }}',
                duration: {{ $trip->duration }},
                reference_code: '{{ $trip->reference_code }}',
                slug: '{{ Str::slug($trip->location) }}',
                google_place_image: '{{ $trip->google_place_image ?: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }}',
                created_diff: '{{ $trip->created_at->diffForHumans() }}',
                is_public: {{ $trip->is_public ? 'true' : 'false' }},
                is_favorited: {{ $trip->isFavoritedBy(Auth::user()) ? 'true' : 'false' }},
                showShare: false
            },
            @endforeach
        ],
        favorites: [
            @foreach($favorites as $trip)
            {
                id: {{ $trip->id }},
                location: '{{ addslashes($trip->location) }}',
                duration: {{ $trip->duration }},
                reference_code: '{{ $trip->reference_code }}',
                slug: '{{ Str::slug($trip->location) }}',
                google_place_image: '{{ $trip->google_place_image ?: 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }}',
                created_diff: '{{ $trip->created_at->diffForHumans() }}',
                is_public: {{ $trip->is_public ? 'true' : 'false' }},
                is_favorited: true,
                showShare: false
            },
            @endforeach
        ],
        get filteredTrips() {
            return this.trips.filter(t => t.location.toLowerCase().includes(this.searchQuery.toLowerCase()));
        },
        get filteredFavorites() {
            return this.favorites.filter(t => t.location.toLowerCase().includes(this.searchQuery.toLowerCase()));
        },
        async toggleFavorite(trip) {
            try {
                let res = await fetch(`/trips/${trip.id}/favorite`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                let data = await res.json();
                if (data.success) {
                    trip.is_favorited = data.favorited;
                    
                    if (data.favorited) {
                        if (!this.favorites.find(f => f.id === trip.id)) {
                            this.favorites.push({ ...trip, is_favorited: true });
                        }
                    } else {
                        this.favorites = this.favorites.filter(f => f.id !== trip.id);
                    }
                    
                    let mainTrip = this.trips.find(t => t.id === trip.id);
                    if (mainTrip) mainTrip.is_favorited = data.favorited;

                    this.addToast(data.message, 'success');
                }
            } catch(e) {
                this.addToast('Failed to toggle favorite.', 'error');
            }
        },
        async toggleVisibility(trip) {
            try {
                let res = await fetch(`/trips/${trip.id}/toggle-visibility`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                let data = await res.json();
                if (data.success) {
                    trip.is_public = data.is_public;
                    
                    let favTrip = this.favorites.find(f => f.id === trip.id);
                    if (favTrip) favTrip.is_public = data.is_public;

                    let mainTrip = this.trips.find(t => t.id === trip.id);
                    if (mainTrip) mainTrip.is_public = data.is_public;

                    this.addToast(data.message, 'success');
                }
            } catch(e) {
                this.addToast('Failed to toggle visibility.', 'error');
            }
        },
        copyShareLink(trip) {
            const link = `{{ url('/trip') }}/${trip.reference_code}/${trip.slug}`;
            navigator.clipboard.writeText(link).then(() => {
                this.addToast('Link copied to clipboard!', 'success');
                trip.showShare = false;
            }).catch(() => {
                this.addToast('Failed to copy link.', 'error');
            });
        },
        addToast(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type });
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 3500);
        }
    }">
        
        <!-- Toast Container -->
        <div class="fixed bottom-5 right-5 z-[999] flex flex-col gap-2 pointer-events-none">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-transition:enter="transition ease-out duration-300 transform translate-y-2 opacity-0"
                     x-transition:enter-end="transform translate-y-0 opacity-100"
                     x-transition:leave="transition ease-in duration-200 transform translate-y-2 opacity-0"
                     class="px-4 py-3 rounded-2xl shadow-xl flex items-center gap-2.5 pointer-events-auto border min-w-[300px] bg-white backdrop-blur-xl"
                     :class="{
                         'border-green-100 text-green-800 bg-green-50/90': toast.type === 'success',
                         'border-red-100 text-red-800 bg-red-50/90': toast.type === 'error'
                     }">
                    <template x-if="toast.type === 'success'">
                        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </template>
                    <template x-if="toast.type === 'error'">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </template>
                    <span x-text="toast.message" class="text-sm font-semibold"></span>
                </div>
            </template>
        </div>

        <!-- Hero Section -->
        <section class="relative bg-white border-b border-gray-100 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 relative">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-2xl">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary mb-4">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Personal Dashboard
                        </span>
                        <h1 class="text-3xl lg:text-4xl font-black text-gray-900 tracking-tight mb-2">
                            Welcome Back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-primary-light">{{ Auth::user()->name }}</span>
                        </h1>
                        <p class="text-gray-500 text-sm md:text-base leading-relaxed">
                            Access all your generated plans, customize preferences, track statistics, and share itineraries with the world.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        @if(count($trips) === 0)
                            <button @click="showOnboarding = true" class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-200 text-sm font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 shadow-sm transition-all">
                                <svg class="w-4 h-4 mr-2 text-yellow-500 fill-current" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1.323l3.945-1.183a1 1 0 011.265.582l.8 2a1 1 0 01-.482 1.265L12.323 10l3.205 3.963a1 1 0 01.482 1.265l-.8 2a1 1 0 01-1.265.582L11 16.677V18a1 1 0 11-2 0v-1.323l-3.945 1.183a1 1 0 01-1.265-.582l-.8-2a1 1 0 01.482-1.265L7.677 10 4.472 6.037a1 1 0 01-.482-1.265l.8-2a1 1 0 011.265-.582L9 4.323V3a1 1 0 011-1z"/></svg>
                                Quick Guide
                            </button>
                        @endif
                        <a href="{{ route('createPlan') }}" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-semibold rounded-xl text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary shadow-lg shadow-primary/25 transition-all">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Plan a New Trip
                        </a>
                    </div>
                </div>

                <!-- Decorative Background Pattern -->
                <div class="absolute right-0 top-1/2 transform -translate-y-1/2 opacity-[0.02] pointer-events-none">
                     <svg width="404" height="404" fill="none" viewBox="0 0 404 404"><defs><pattern id="dashboard-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="4" height="4" class="text-gray-900" fill="currentColor" /></pattern></defs><rect width="404" height="404" fill="url(#dashboard-pattern)" /></svg>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            
            <!-- Statistics Bar -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
                <!-- Stat 1 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    </div>
                    <div>
                        <span class="block text-2xl font-black text-gray-900 tracking-tight">{{ $totalTrips }}</span>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mt-0.5">Trips Planned</span>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-emerald-500/10 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <span class="block text-2xl font-black text-gray-900 tracking-tight">{{ $totalDays }}</span>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mt-0.5">Total Days Traveled</span>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex items-center gap-5 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-indigo-500/10 text-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <div>
                        <span class="block text-2xl font-black text-gray-900 tracking-tight">{{ $uniqueDestinations }}</span>
                        <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mt-0.5">Destinations Explored</span>
                    </div>
                </div>
            </div>

            <!-- Upcoming Trip Countdown -->
            @if($upcomingTrip)
                <div x-data="{
                    targetDate: new Date('{{ $upcomingTrip->checkInDate }}T00:00:00').getTime(),
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                    hasStarted: false,
                    update() {
                        const now = new Date().getTime();
                        const diff = this.targetDate - now;
                        if (diff <= 0) {
                            this.hasStarted = true;
                            return;
                        }
                        this.days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        this.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        this.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        this.seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    }
                }" x-init="update(); setInterval(() => update(), 1000)" class="bg-gradient-to-r from-primary to-primary-light text-white rounded-3xl p-6 lg:p-8 shadow-xl relative overflow-hidden mb-12 border border-primary/20">
                    <div class="absolute right-0 bottom-0 top-0 w-1/3 opacity-[0.07] bg-no-repeat bg-contain" style="background-image: url('{{ asset('travaiqlogo.png') }}'); background-position: right center;"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white mb-2 backdrop-blur-md">
                                Next Adventure ✈️
                            </span>
                            <h2 class="text-2xl lg:text-3xl font-extrabold tracking-tight">Trip to {{ $upcomingTrip->location }}</h2>
                            <p class="text-white/80 mt-1 text-sm">
                                Starts on <span class="font-bold text-white">{{ Carbon\Carbon::parse($upcomingTrip->checkInDate)->format('F d, Y') }}</span> • <span class="font-bold text-white">{{ $upcomingTrip->duration }} Days</span>
                            </p>
                        </div>

                        <div class="flex items-center gap-3" x-show="!hasStarted">
                            <div class="flex flex-col items-center bg-white/10 backdrop-blur-md rounded-2xl p-3 min-w-[65px] border border-white/10">
                                <span class="text-xl lg:text-2xl font-black tracking-tight" x-text="days">0</span>
                                <span class="text-[9px] uppercase font-bold text-white/70 tracking-widest mt-0.5">Days</span>
                            </div>
                            <div class="flex flex-col items-center bg-white/10 backdrop-blur-md rounded-2xl p-3 min-w-[65px] border border-white/10">
                                <span class="text-xl lg:text-2xl font-black tracking-tight" x-text="hours">0</span>
                                <span class="text-[9px] uppercase font-bold text-white/70 tracking-widest mt-0.5">Hours</span>
                            </div>
                            <div class="flex flex-col items-center bg-white/10 backdrop-blur-md rounded-2xl p-3 min-w-[65px] border border-white/10">
                                <span class="text-xl lg:text-2xl font-black tracking-tight" x-text="minutes">0</span>
                                <span class="text-[9px] uppercase font-bold text-white/70 tracking-widest mt-0.5">Mins</span>
                            </div>
                            <div class="flex flex-col items-center bg-white/10 backdrop-blur-md rounded-2xl p-3 min-w-[65px] border border-white/10">
                                <span class="text-xl lg:text-2xl font-black tracking-tight" x-text="seconds">0</span>
                                <span class="text-[9px] uppercase font-bold text-white/70 tracking-widest mt-0.5">Secs</span>
                            </div>
                        </div>
                        <div x-show="hasStarted" class="bg-white/10 backdrop-blur-md rounded-2xl px-5 py-3 border border-white/10 font-bold">
                            It's departure day! Have a safe flight! 🎉
                        </div>
                    </div>
                </div>
            @endif

            <!-- Navigation, Filter & Content Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <!-- Tabs -->
                <div class="flex bg-gray-100 p-1 rounded-xl w-fit">
                    <button @click="activeTab = 'my-trips'" 
                            class="px-5 py-2 text-sm font-semibold rounded-lg transition-all"
                            :class="activeTab === 'my-trips' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900'">
                        My Trips
                    </button>
                    <button @click="activeTab = 'favorites'" 
                            class="px-5 py-2 text-sm font-semibold rounded-lg transition-all"
                            :class="activeTab === 'favorites' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-900'">
                        Favorites
                    </button>
                </div>

                <!-- Search/Filter -->
                <div class="relative w-full sm:max-w-xs">
                    <input type="text" 
                           x-model="searchQuery" 
                           placeholder="Search destination..." 
                           class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent bg-white shadow-sm transition-all" />
                    <svg class="absolute left-3 top-2.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Grids -->
            <!-- Tab: My Trips -->
            <div x-show="activeTab === 'my-trips'" x-transition:enter="transition ease-out duration-300 opacity-0" x-transition:enter-end="opacity-100">
                <template x-if="filteredTrips.length > 0">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <template x-for="trip in filteredTrips" :key="trip.id">
                            <div class="group relative flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-gray-200/40 transition-all duration-300 hover:-translate-y-1">
                                <!-- Card Image -->
                                <div class="relative h-56 overflow-hidden bg-gray-100">
                                    <a :href="`/trips/reference/${trip.reference_code}`" class="block w-full h-full">
                                        <img :src="trip.google_place_image" :alt="trip.location" 
                                             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/0 to-transparent"></div>
                                    </a>
                                    
                                    <!-- Duration badge -->
                                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-sm border border-white/20">
                                        <span x-text="trip.duration"></span> Days
                                    </div>

                                    <!-- Favorite Toggle -->
                                    <button @click="toggleFavorite(trip)" class="absolute top-4 right-4 p-2 rounded-full bg-white/90 backdrop-blur-sm shadow-sm hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-gray-400 hover:text-red-500 transition-colors"
                                             :class="trip.is_favorited ? 'text-red-500 fill-current' : 'text-gray-400'"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Card Content -->
                                <div class="p-6 flex-grow flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-3">
                                            <div class="flex items-center gap-1 text-primary font-medium text-xs uppercase tracking-wide">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                <span x-text="trip.location"></span>
                                            </div>

                                            <!-- Visibility Toggle Badge -->
                                            <button @click="toggleVisibility(trip)" 
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold border transition-all"
                                                    :class="trip.is_public ? 'bg-green-50 border-green-200 text-green-700 hover:bg-green-100/60' : 'bg-gray-50 border-gray-200 text-gray-500 hover:bg-gray-100/60'">
                                                <span class="w-1.5 h-1.5 rounded-full" :class="trip.is_public ? 'bg-green-500' : 'bg-gray-400'"></span>
                                                <span x-text="trip.is_public ? 'Public' : 'Private'"></span>
                                            </button>
                                        </div>

                                        <a :href="`/trips/reference/${trip.reference_code}`" class="block">
                                            <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-primary transition-colors">
                                                Itinerary to <span x-text="trip.location"></span>
                                            </h3>
                                        </a>

                                        <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed mb-4">
                                            Explore custom routes, recommended dining options, hotel guides, and top local landmarks.
                                        </p>
                                    </div>

                                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between relative">
                                        <span class="text-[11px] text-gray-400 font-medium" x-text="trip.created_diff"></span>

                                        <div class="flex items-center gap-2">
                                            <!-- Share Button & Popover -->
                                            <div class="relative">
                                                <button @click="trip.showShare = !trip.showShare" class="p-2 rounded-lg text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.742l4.684-2.342m0 0l4.684 2.342m-4.684-2.342L12 3m0 0L7.316 5.342M12 3v18" /></svg>
                                                </button>

                                                <!-- Popover Menu -->
                                                <div x-show="trip.showShare" @click.away="trip.showShare = false" 
                                                     class="absolute right-0 bottom-full mb-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl py-1.5 z-40" 
                                                     style="display: none;">
                                                    <button @click="copyShareLink(trip)" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors text-left">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                                                        Copy Link
                                                    </button>
                                                    <a :href="`https://twitter.com/intent/tweet?url=${encodeURIComponent('{{ url('/trip') }}/' + trip.reference_code + '/' + trip.slug)}&text=${encodeURIComponent('Check out my custom travel itinerary to ' + trip.location + ' on TravaiQ!')}`"
                                                       target="_blank"
                                                       class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                                        Share on Twitter
                                                    </a>
                                                    <a :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent('{{ url('/trip') }}/' + trip.reference_code + '/' + trip.slug)}`"
                                                       target="_blank"
                                                       class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
                                                        Share on Facebook
                                                    </a>
                                                </div>
                                            </div>

                                            <a :href="`/trips/reference/${trip.reference_code}`" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-primary hover:bg-primary/95 shadow-sm transition-all">
                                                Details
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="filteredTrips.length === 0">
                    <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-5 text-primary">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">No trips found</h3>
                        <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">Create a customized, AI-generated travel itinerary matching your requirements in seconds.</p>
                        <a href="{{ route('createPlan') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-primary hover:bg-primary/95 shadow-lg shadow-primary/25 transition-all">
                            Start Planning Now
                        </a>
                    </div>
                </template>
            </div>

            <!-- Tab: Favorites -->
            <div x-show="activeTab === 'favorites'" x-transition:enter="transition ease-out duration-300 opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
                <template x-if="filteredFavorites.length > 0">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <template x-for="trip in filteredFavorites" :key="trip.id">
                            <div class="group relative flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-gray-200/40 transition-all duration-300 hover:-translate-y-1">
                                <!-- Card Image -->
                                <div class="relative h-56 overflow-hidden bg-gray-100">
                                    <a :href="`/trips/reference/${trip.reference_code}`" class="block w-full h-full">
                                        <img :src="trip.google_place_image" :alt="trip.location" 
                                             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/0 to-transparent"></div>
                                    </a>
                                    
                                    <!-- Duration badge -->
                                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-sm border border-white/20">
                                        <span x-text="trip.duration"></span> Days
                                    </div>

                                    <!-- Favorite Toggle -->
                                    <button @click="toggleFavorite(trip)" class="absolute top-4 right-4 p-2 rounded-full bg-white/90 backdrop-blur-sm shadow-sm hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 text-red-500 fill-current transition-colors"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Card Content -->
                                <div class="p-6 flex-grow flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between gap-2 mb-3">
                                            <div class="flex items-center gap-1 text-primary font-medium text-xs uppercase tracking-wide">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                <span x-text="trip.location"></span>
                                            </div>

                                            <!-- Visibility Toggle Badge -->
                                            <button @click="toggleVisibility(trip)" 
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold border transition-all"
                                                    :class="trip.is_public ? 'bg-green-50 border-green-200 text-green-700 hover:bg-green-100/60' : 'bg-gray-50 border-gray-200 text-gray-500 hover:bg-gray-100/60'">
                                                <span class="w-1.5 h-1.5 rounded-full" :class="trip.is_public ? 'bg-green-500' : 'bg-gray-400'"></span>
                                                <span x-text="trip.is_public ? 'Public' : 'Private'"></span>
                                            </button>
                                        </div>

                                        <a :href="`/trips/reference/${trip.reference_code}`" class="block">
                                            <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-primary transition-colors">
                                                Itinerary to <span x-text="trip.location"></span>
                                            </h3>
                                        </a>

                                        <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed mb-4">
                                            Explore custom routes, recommended dining options, hotel guides, and top local landmarks.
                                        </p>
                                    </div>

                                    <div class="pt-4 border-t border-gray-50 flex items-center justify-between relative">
                                        <span class="text-[11px] text-gray-400 font-medium" x-text="trip.created_diff"></span>

                                        <div class="flex items-center gap-2">
                                            <!-- Share Button & Popover -->
                                            <div class="relative">
                                                <button @click="trip.showShare = !trip.showShare" class="p-2 rounded-lg text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 10.742l4.684-2.342m0 0l4.684 2.342m-4.684-2.342L12 3m0 0L7.316 5.342M12 3v18" /></svg>
                                                </button>

                                                <!-- Popover Menu -->
                                                <div x-show="trip.showShare" @click.away="trip.showShare = false" 
                                                     class="absolute right-0 bottom-full mb-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl py-1.5 z-40" 
                                                     style="display: none;">
                                                    <button @click="copyShareLink(trip)" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors text-left">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                                                        Copy Link
                                                    </button>
                                                    <a :href="`https://twitter.com/intent/tweet?url=${encodeURIComponent('{{ url('/trip') }}/' + trip.reference_code + '/' + trip.slug)}&text=${encodeURIComponent('Check out my custom travel itinerary to ' + trip.location + ' on TravaiQ!')}`"
                                                       target="_blank"
                                                       class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                                        Share on Twitter
                                                    </a>
                                                    <a :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent('{{ url('/trip') }}/' + trip.reference_code + '/' + trip.slug)}`"
                                                       target="_blank"
                                                       class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">
                                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/></svg>
                                                        Share on Facebook
                                                    </a>
                                                </div>
                                            </div>

                                            <a :href="`/trips/reference/${trip.reference_code}`" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-primary hover:bg-primary/95 shadow-sm transition-all">
                                                Details
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="filteredFavorites.length === 0">
                    <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-5">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">No favorites saved</h3>
                        <p class="text-gray-500 text-sm max-w-sm mx-auto">Click the heart icon on any generated itinerary card to save it to your wishlist here.</p>
                    </div>
                </template>
            </div>

        </div>

        <!-- Onboarding Modal -->
        <div x-show="showOnboarding" 
             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" 
             style="display: none;">
            
            <!-- Backdrop -->
            <div x-show="showOnboarding"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showOnboarding = false"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-md transition-opacity"></div>

            <!-- Modal Content Wrapper -->
            <div x-show="showOnboarding"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-3xl shadow-2xl overflow-hidden max-w-lg w-full z-10 border border-gray-100">
                
                <!-- Close Button -->
                <button @click="showOnboarding = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-20 p-1.5 rounded-full hover:bg-gray-50 transition-colors">
                    <svg class="h-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Modal Body -->
                <div class="px-6 py-10 lg:p-10 flex flex-col items-center text-center">
                    
                    <!-- Step 1: Welcome -->
                    <div x-show="onboardingStep === 1" class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-primary/10 rounded-3xl flex items-center justify-center text-primary mb-6 animate-bounce">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        </div>
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Welcome to TravaiQ!</h2>
                        <p class="text-gray-500 text-sm mt-3 leading-relaxed">
                            Your personalized, AI-powered travel assistant is ready to help you plan your next dream getaway in less than 30 seconds.
                        </p>
                    </div>

                    <!-- Step 2: How It Works -->
                    <div x-show="onboardingStep === 2" class="flex flex-col items-center w-full">
                        <h2 class="text-xl font-black text-gray-900 tracking-tight mb-6">How It Works</h2>
                        
                        <div class="space-y-5 text-left w-full">
                            <!-- Step 2.1 -->
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary font-bold text-sm flex items-center justify-center shrink-0">1</div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Tell us your preferences</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Input your destination, trip dates, budget range, and type of traveler.</p>
                                </div>
                            </div>
                            <!-- Step 2.2 -->
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary font-bold text-sm flex items-center justify-center shrink-0">2</div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Get curated AI plans</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">We build a comprehensive itinerary including hotel options, daily activities, and dining guides.</p>
                                </div>
                            </div>
                            <!-- Step 2.3 -->
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary font-bold text-sm flex items-center justify-center shrink-0">3</div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">Favorite, Share & Export</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Save itineraries to your favorites list, share links publicly, or export a PDF file.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Call to Action -->
                    <div x-show="onboardingStep === 3" class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-3xl flex items-center justify-center mb-6">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Ready for Adventure?</h2>
                        <p class="text-gray-500 text-sm mt-3 leading-relaxed">
                            Create your first itinerary now and start exploring new cities and landmarks.
                        </p>
                    </div>

                    <!-- Modal Actions -->
                    <div class="mt-8 flex items-center justify-between w-full border-t border-gray-50 pt-5">
                        <!-- Left indicator / pagination dot -->
                        <div class="flex gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full transition-all" :class="onboardingStep === 1 ? 'bg-primary' : 'bg-gray-200'"></span>
                            <span class="w-2.5 h-2.5 rounded-full transition-all" :class="onboardingStep === 2 ? 'bg-primary' : 'bg-gray-200'"></span>
                            <span class="w-2.5 h-2.5 rounded-full transition-all" :class="onboardingStep === 3 ? 'bg-primary' : 'bg-gray-200'"></span>
                        </div>

                        <div class="flex gap-2">
                            <!-- Prev -->
                            <button x-show="onboardingStep > 1" 
                                    @click="onboardingStep--" 
                                    class="px-4 py-2 border border-gray-200 text-xs font-semibold rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                Back
                            </button>

                            <!-- Next -->
                            <button x-show="onboardingStep < 3" 
                                    @click="onboardingStep++" 
                                    class="px-5 py-2 text-xs font-semibold rounded-xl text-white bg-primary hover:bg-primary/95 shadow-sm transition-colors">
                                Next
                            </button>

                            <!-- CTA -->
                            <a x-show="onboardingStep === 3" 
                               href="{{ route('createPlan') }}"
                               class="px-5 py-2 text-xs font-semibold rounded-xl text-white bg-primary hover:bg-primary/95 shadow-md shadow-primary/20 transition-all">
                                Let's Go!
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>

@endsection