@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-300">
    <div class="max-w-lg w-full bg-white rounded-3xl shadow-2xl p-10 text-center animate-fade-in">
        <div class="flex justify-center mb-6">
            <svg class="w-20 h-20 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="text-6xl font-extrabold text-orange-500 mb-2 tracking-wider">419</div>
        <h1 class="text-3xl font-semibold text-gray-800 mb-3">Page Expired</h1>
        <p class="text-gray-600 mb-6">Your session has expired. Please refresh the page or return home to continue.</p>
        <a href="{{ url('') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-full font-medium hover:bg-blue-700 transition duration-300 ease-in-out shadow-md">
            🔄 Return to Homepage
        </a>
    </div>
</div>

<style>
    @keyframes fade-in {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out forwards;
    }
</style>
@endsection
