@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Sitemap</h1>
        
        <div class="space-y-8">
            <!-- Main Pages -->
            <div>
                <h2 class="text-2xl font-semibold text-primary mb-4">Main Pages</h2>
                <ul class="space-y-2">
                    <li><a href="{{ url('/') }}" class="text-gray-600 hover:text-primary transition duration-300">Home</a></li>
                    <li><a href="{{ route('createPlan') }}" class="text-gray-600 hover:text-primary transition duration-300">Trip Planner</a></li>
                    <li><a href="{{ route('travel.guide') }}" class="text-gray-600 hover:text-primary transition duration-300">Travel Guide</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-600 hover:text-primary transition duration-300">Contact Us</a></li>
                </ul>
            </div>

            <!-- User Account -->
            <div>
                <h2 class="text-2xl font-semibold text-primary mb-4">User Account</h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('google.redirect') }}" class="text-gray-600 hover:text-primary transition duration-300">Sign In</a></li>
                    @if (Auth::check())
                    <li><a href="{{ route('my.trips') }}" class="text-gray-600 hover:text-primary transition duration-300">My Trips</a></li>
                    @endif
                </ul>
            </div>

            <!-- Resources -->
            <div>
                <h2 class="text-2xl font-semibold text-primary mb-4">Resources</h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('travel.guide') }}" class="text-gray-600 hover:text-primary transition duration-300">Travel Guide</a></li>
                    <li><a href="{{ route('faqs') }}" class="text-gray-600 hover:text-primary transition duration-300">FAQs</a></li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h2 class="text-2xl font-semibold text-primary mb-4">Legal</h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('privacy.policy') }}" class="text-gray-600 hover:text-primary transition duration-300">Privacy Policy</a></li>
                    <li><a href="{{ route('terms.of.service') }}" class="text-gray-600 hover:text-primary transition duration-300">Terms of Service</a></li>
                    <li><a href="{{ route('cookie.policy') }}" class="text-gray-600 hover:text-primary transition duration-300">Cookie Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 