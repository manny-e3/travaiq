@extends('layouts.app')

@section('title', 'Travel Guide - Travaiq')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-white min-h-screen">
    



        <!-- Page Title Section -->
        <section class="bg-gradient-to-r from-primary-dark via-primary to-primary-light text-white py-16 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-full h-full">
            <svg class="absolute right-0 top-0 h-full opacity-10" viewBox="0 0 500 500" width="500" height="500" preserveAspectRatio="xMinYMin meet">
                <path d="M488.6,259.8c0,98.5-80.1,178.3-178.9,178.3s-178.9-79.8-178.9-178.3c0-98.5,80.1-178.3,178.9-178.3S488.6,161.3,488.6,259.8z" fill="white"/>
                <circle cx="168" cy="213.8" r="14.8" fill="white"/>
                <circle cx="126.3" cy="311.7" r="24.2" fill="white"/>
                <circle cx="244.8" cy="348.7" r="10.2" fill="white"/>
                <circle cx="291.5" cy="267.1" r="14.2" fill="white"/>
                <circle cx="380.4" cy="173.6" r="22.6" fill="white"/>
            </svg>
        </div>
        <div class="container mx-auto px-4 text-center relative">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 animate__animated animate__fadeIn">Your Adventure Starts Here</h1>
            <p class="text-xl mb-3 animate__animated animate__fadeIn animate__delay-1s">Get inspired and plan your perfect getaway with Travaiq</p>
            <p class="text-lg opacity-90 animate__animated animate__fadeIn animate__delay-2s">Your personalized travel itinerary is just a few clicks away</p>
            <div class="mt-8 flex justify-center gap-4">
                <div class="animate-float ">
                <a href="{{ route('createPlan') }}" class="inline-block px-8 py-3 rounded-full bg-gradient-to-r from-primary to-primary-light text-white font-medium shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1 flex items-center">
                            <span>Start Planning Now</span>
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                </div>
               
            </div>
        </div>
    </section>

    <div class="max-w-6xl mx-auto py-12 px-4">
        <!-- Introduction -->
        <div class="mb-12 text-center">
            <h2 class="text-3xl font-semibold mb-4">Welcome to the Travaiq Travel Guide!</h2>
            <p class="text-lg mb-2">Discover top destinations, travel tips, and must-see attractions tailored to your interests.</p>
            <p>From solo adventures to romantic getaways, we've got the advice and insights to help you explore with confidence.</p>
        </div>

        <!-- Popular Destinations -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Popular Destinations</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['region' => 'Europe', 'places' => [
                        'Paris, France - The City of Light',
                        'Rome, Italy - Ancient History & Culture',
                        'Barcelona, Spain - Art & Architecture',
                        'Amsterdam, Netherlands - Canals & Culture'
                    ]],
                    ['region' => 'Asia', 'places' => [
                        'Tokyo, Japan - Modern & Traditional',
                        'Bali, Indonesia - Tropical Paradise',
                        'Bangkok, Thailand - Street Food & Temples',
                        'Seoul, South Korea - K-Pop & Technology'
                    ]],
                    ['region' => 'Africa', 'places' => [
                        'Cape Town, South Africa - Natural Beauty',
                        'Marrakech, Morocco - Cultural Heritage',
                        'Serengeti, Tanzania - Wildlife Safari',
                        'Victoria Falls, Zambia/Zimbabwe - Natural Wonder'
                    ]],
                    ['region' => 'America', 'places' => [
                        'New York, USA - The Big Apple',
                        'Rio de Janeiro, Brazil - Carnival & Beaches',
                        'Banff, Canada - Mountain Paradise',
                        'Mexico City, Mexico - Rich Culture & History'
                    ]]
                ] as $destination)
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition transform hover:-translate-y-1 duration-300">
                        <h3 class="text-xl font-semibold mb-3">{{ $destination['region'] }}</h3>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-700">
                            @foreach($destination['places'] as $place)
                                <li>{{ $place }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Travel Tips -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Essential Travel Tips</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['title' => 'Before You Go', 'tips' => ['Check visa requirements', 'Get travel insurance', 'Research local customs', 'Learn basic phrases']],
                    ['title' => 'Packing Smart', 'tips' => ['Pack light & versatile', 'Bring essential documents', 'Include first-aid kit', 'Pack weather-appropriate clothes']],
                    ['title' => 'Safety First', 'tips' => ['Keep copies of documents', 'Stay aware of surroundings', 'Use secure connections', 'Know emergency numbers']]
                ] as $tip)
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition transform hover:-translate-y-1 duration-300">
                        <h3 class="text-xl font-semibold mb-3">{{ $tip['title'] }}</h3>
                        <ul class="list-disc list-inside space-y-2 text-sm text-gray-700">
                            @foreach($tip['tips'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Best Time to Travel -->
        <div class="mb-12">
            <h2 class="text-2xl font-semibold mb-6 text-center">Best Time to Travel</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xl font-semibold mb-2">🌸 Spring (March–May)</h3>
                        <p class="text-sm text-gray-600 mb-2">Perfect for:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700 text-sm">
                            <li>Cherry blossom viewing in Japan</li>
                            <li>European city breaks</li>
                            <li>Wildlife safaris in Africa</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">☀️ Summer (June–August)</h3>
                        <p class="text-sm text-gray-600 mb-2">Perfect for:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700 text-sm">
                            <li>Beach vacations</li>
                            <li>Festivals in Europe</li>
                            <li>National park visits</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-12">
            <p class="text-lg mb-4">Ready to start your adventure?</p>

            <a href="{{ route('createPlan') }}" class="inline-block px-8 py-3 rounded-full bg-gradient-to-r from-primary to-primary-light text-white font-medium ">
                            <span>Explore Destinations</span>
                          
                        </a>
            
            <!-- <a href="{{ route('createPlan') }}" class="ipx-8 py-3  bg-gradient-to-r from-primary to-primary-light text-white font-medium   items-center">
          
                Explore Destinations
            </a> -->

            <!-- class="inline-block px-8 py-3 rounded-full bg-gradient-to-r from-primary to-primary-light text-white font-medium shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1 flex items-center" -->
        </div>
    </div>
</div>
@endsection
