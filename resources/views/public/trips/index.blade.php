@extends('layouts.app')

@section('title', 'Explore Travel Itineraries - Travaiq')
@section('meta_description', 'Browse a collection of curated travel itineraries. Find inspiration for your next trip to Paris, Tokyo, Bali, and more.')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-3xl md:text-5xl font-bold mb-6 text-gray-900">Explore Public Itineraries</h1>
            <p class="text-xl text-gray-500">Discover amazing trips planned by our community and AI.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($trips as $trip)
            <a href="{{ route('public.trip.show', ['reference' => $trip->reference_code, 'location' => \Illuminate\Support\Str::slug($trip->location)]) }}" class="block group">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-full flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                         @if($trip->google_place_image)
                            <img src="{{ $trip->google_place_image }}" alt="{{ $trip->location }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                             <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                 <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                             </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-sm">
                            {{ $trip->duration }} Days
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary transition-colors">{{ $trip->location }}</h3>
                            <p class="text-gray-600 line-clamp-3 text-sm">{{ $trip->meta_description ?? 'Explore this amazing itinerary for ' . $trip->location }}</p>
                        </div>
                        <div class="mt-4 flex items-center text-primary font-semibold text-sm">
                            View Itinerary 
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500 text-lg">No public itineraries found yet.</p>
                <a href="{{ route('createPlan') }}" class="inline-block mt-4 text-primary font-bold hover:underline">Create the first one!</a>
            </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $trips->links() }}
        </div>
    </div>
</div>
@endsection
