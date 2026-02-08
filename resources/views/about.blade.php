@extends('layouts.app')

@section('title', 'About Travaiq - Travaiq')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-indigo-50">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-7xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                        <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                <span class="block">Transform Your</span>
                                <span class="block text-primary">Travel Experience</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Revolutionizing travel planning with AI-powered insights and personalized recommendations for unforgettable journeys.
                            </p>
                            <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">
                                <div class="mt-10 flex flex-col sm:flex-row sm:justify-center lg:justify-start">
                                    <div class="rounded-md shadow">
                                        <a href="{{ route('createPlan') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark md:py-4 md:text-lg md:px-10 transition duration-300">
                                            Create Your Plan
                                        </a>
                                    </div>
                                    <div class="mt-3 sm:mt-0 sm:ml-3">
                                        <a href="{{ route('travel.guide') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10 transition duration-300">
                                            Explore Guides
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                            <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                                <div class="relative block w-full bg-white rounded-lg overflow-hidden">
                                    <div class="aspect-w-16 aspect-h-9">
                                        <div class="bg-gradient-to-r from-primary to-primary-light h-64 w-full rounded-lg flex items-center justify-center">
                                            <div class="text-center p-6">
                                                <svg class="mx-auto h-16 w-16 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <h3 class="mt-4 text-xl font-bold text-white">AI-Powered Travel Planning</h3>
                                                <p class="mt-2 text-indigo-100">Personalized itineraries in seconds</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Trusted by Travelers Worldwide</h2>
                <p class="mt-3 text-xl text-gray-500 sm:mt-4">Join thousands of travelers who have transformed their travel planning experience.</p>
            </div>
        </div>
        <div class="mt-10 bg-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="text-center">
                        <p class="text-5xl font-extrabold text-primary">10K+</p>
                        <p class="mt-2 text-base font-medium text-gray-500">Travel Plans Created</p>
                    </div>
                    <div class="text-center">
                        <p class="text-5xl font-extrabold text-primary">98%</p>
                        <p class="mt-2 text-base font-medium text-gray-500">Customer Satisfaction</p>
                    </div>
                    <div class="text-center">
                        <p class="text-5xl font-extrabold text-primary">50+</p>
                        <p class="mt-2 text-base font-medium text-gray-500">Destinations Covered</p>
                    </div>
                    <div class="text-center">
                        <p class="text-5xl font-extrabold text-primary">24/7</p>
                        <p class="mt-2 text-base font-medium text-gray-500">AI Assistance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Vision Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-16">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Our Purpose</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Mission & Vision
                </p>
            </div>
            
            <div class="lg:grid lg:grid-cols-2 lg:gap-16">
                <div class="mb-12 lg:mb-0">
                    <div class="bg-gradient-to-br from-primary to-primary-light rounded-2xl p-8 shadow-xl">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-white text-primary">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="ml-4 text-2xl font-bold text-white">Our Mission</h3>
                        </div>
                        <p class="text-lg text-indigo-100">
                            To empower travelers with intelligent, personalized travel planning solutions that save time, reduce stress, and enhance travel experiences through cutting-edge AI technology.
                        </p>
                    </div>
                </div>
                
                <div>
                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-8 shadow-xl">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                </svg>
                            </div>
                            <h3 class="ml-4 text-2xl font-bold text-white">Our Vision</h3>
                        </div>
                        <p class="text-lg text-gray-300">
                            To become the world's most trusted AI-powered travel companion, revolutionizing how people discover, plan, and experience travel by making personalized travel planning accessible to everyone.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Travaiq Section -->
    <div class="py-16 bg-gradient-to-br from-indigo-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Why Choose Travaiq?</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    The Travaiq Advantage
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
                    We combine cutting-edge technology with travel expertise to deliver unparalleled planning experiences.
                </p>
            </div>
            <div class="mt-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary text-white flex-shrink-0">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900">Personalization</h3>
                            <p class="mt-4 text-base text-gray-500">
                                Every recommendation is tailored to your unique interests, travel style, and budget using advanced AI algorithms.
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary text-white flex-shrink-0">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900">Real-time Updates</h3>
                            <p class="mt-4 text-base text-gray-500">
                                Get instant recommendations and updates based on weather, events, and your current location during your trip.
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="flex items-center justify-center h-16 w-16 rounded-full bg-primary text-white flex-shrink-0">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900">Trusted Data</h3>
                            <p class="mt-4 text-base text-gray-500">
                                We aggregate information from verified sources and community reviews to ensure reliable and accurate recommendations.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center mb-12">
                <h2 class="text-base text-primary font-semibold tracking-wide uppercase">Our Solutions</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Comprehensive Travel Planning
                </p>
            </div>

            <div class="mt-10">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <!-- Feature 1 -->
                    <div class="relative bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Smart Itinerary Planning</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Our AI analyzes your preferences to create perfectly tailored travel itineraries with optimal timing and routing.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Real-time Recommendations</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Get instant suggestions for activities, restaurants, and attractions based on your location and preferences.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Time Optimization</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Maximize your travel time with efficient route planning and scheduling that considers traffic and wait times.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4 -->
                    <div class="relative bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-16">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Community Insights</h3>
                            <p class="mt-2 text-base text-gray-500">
                                Access valuable tips and recommendations from our community of experienced travelers worldwide.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-primary to-primary-dark">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <div class="lg:w-0 lg:flex-1">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Ready to transform your travel planning?
                </h2>
                <p class="mt-4 max-w-3xl text-lg text-indigo-100">
                    Join thousands of travelers who are already using AI to plan unforgettable journeys.
                </p>
            </div>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('createPlan') }}" class="inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-indigo-50 transition duration-300">
                        Get Started Now
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-4 border border-transparent text-base font-medium rounded-md text-white bg-indigo-900 bg-opacity-60 hover:bg-opacity-50 transition duration-300">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection