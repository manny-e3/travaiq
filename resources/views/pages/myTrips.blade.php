@extends('layouts.app')

@section('title', 'My Trips - Travaiq')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 bg-gray-50 min-h-screen">
        
        <!-- Hero Section -->
        <section class="relative bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 relative overflow-hidden">
                <div class="relative z-10 max-w-2xl">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 mb-6">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Personal Dashboard
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">
                        Your Travel <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Collection</span>
                    </h1>
                    <p class="text-xl text-gray-500 leading-relaxed">
                        Access your generated itineraries, manage past trips, and continue planning your next adventure.
                    </p>
                </div>
                
                <!-- Decorative Element -->
                <div class="absolute right-0 top-1/2 transform -translate-y-1/2 opacity-5 scale-150 pointer-events-none">
                     <svg width="404" height="404" fill="none" viewBox="0 0 404 404"><defs><pattern id="85737c0e-0916-41d7-917f-596dc7edfa27" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" /></pattern></defs><rect width="404" height="404" fill="url(#85737c0e-0916-41d7-917f-596dc7edfa27)" /></svg>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <!-- Action Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
                <div class="flex items-baseline space-x-4">
                     <h2 class="text-2xl font-bold text-gray-900">All Itineraries</h2>
                     <span class="text-sm text-gray-500 font-medium bg-white px-3 py-1 rounded-full shadow-sm border border-gray-100">
                        {{ count($trips) }} total
                     </span>
                </div>

                <a href="{{ route('createPlan') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create New Trip
                </a>
            </div>

            <!-- Grid -->
            @if(count($trips) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($trips as $trip)
                        <article class="group relative flex flex-col bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300 hover:-translate-y-1">
                            
                            <!-- Image Container -->
                            <div class="relative h-64 overflow-hidden bg-gray-200">
                                <a href="{{ route('trips.show.reference', $trip->reference_code) }}" class="block w-full h-full">
                                    @if($trip->google_place_image)
                                        <img src="{{ $trip->google_place_image }}" alt="{{ $trip->location }}" 
                                             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="{{ $trip->location }}" 
                                             class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
                                    @endif
                                    
                                    <!-- Overlay Gradient -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-transparent opacity-60 group-hover:opacity-70 transition-opacity"></div>
                                </a>
                                
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-sm">
                                    {{ $trip->duration }} Days
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 p-6 flex flex-col">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-3">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="text-sm font-medium text-blue-600 uppercase tracking-wide">{{ $trip->location }}</span>
                                    </div>
                                    
                                    <a href="{{ route('trips.show.reference', $trip->reference_code) }}" class="block">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                            Trip to {{ $trip->location }}
                                        </h3>
                                    </a>
                                    
                                    <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                                        Experience the best of {{ $trip->location }} with a curated {{ $trip->duration }}-day itinerary featuring top attractions and hidden gems.
                                    </p>
                                </div>

                                <div class="mt-6 pt-6 border-t border-gray-50 flex items-center justify-between">
                                    <div class="text-xs text-gray-400 font-medium flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $trip->created_at->diffForHumans() }}
                                    </div>
                                    
                                    <a href="{{ route('trips.show.reference', $trip->reference_code) }}" class="text-sm font-semibold text-gray-900 hover:text-blue-600 flex items-center transition-colors">
                                        View Details
                                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Custom Pagination -->
                <div class="mt-12">
                     {{-- Pagination logic here if using actual paginate() --}}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No trips planned yet</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Your adventure awaits! Create your first AI-generated travel plan in seconds.</p>
                    <a href="{{ route('createPlan') }}" class="inline-flex items-center px-8 py-4 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-xl shadow-blue-500/30 transition-all hover:-translate-y-1">
                        Start Planning Now
                    </a>
                </div>
            @endif

        </div>
    </main>

@endsection