@extends('layouts.app')

@section('title', 'Verify Your Email — TravaiQ')

@section('content')
<main class="flex-grow flex items-center justify-center bg-gray-50/50 min-h-[80vh] relative py-12 px-4 sm:px-6 lg:px-8">
    <!-- Decorative blobs -->
    <div class="fixed top-1/4 -left-32 w-96 h-96 bg-primary rounded-full opacity-[0.03] blur-3xl pointer-events-none"></div>
    <div class="fixed bottom-1/4 -right-32 w-96 h-96 bg-accent rounded-full opacity-[0.03] blur-3xl pointer-events-none"></div>

    <div class="max-w-md w-full space-y-8 relative z-10">
        <!-- Brand Logo and Subtitle -->
        <div class="text-center animate-fade-in-down">
            <h2 class="text-3xl font-extrabold text-gray-900 font-heading">
                Verify Your <span class="text-gradient">Email</span>
            </h2>
            <p class="mt-2 text-sm text-gray-500">
                You're almost there! We need to verify your email address.
            </p>
        </div>

        <!-- Glassmorphic Card -->
        <div class="glass-card p-8 shadow-xl animate-scale-in">
            <!-- Alert Banner -->
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Informational Message -->
            <div class="text-center space-y-6">
                <!-- Icon -->
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto text-primary animate-pulse-slow">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-5.333a2 2 0 012.22 0l8 5.333A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-2.25-1.5a2 2 0 00-2.22 0l-2.25 1.5"></path>
                    </svg>
                </div>

                <div class="space-y-3">
                    <p class="text-base text-gray-700 leading-relaxed">
                        Before proceeding, please check your email inbox for a verification link.
                    </p>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        If you didn't receive the email, we can easily send you another one.
                    </p>
                </div>

                <!-- Form to Resend link -->
                <form method="POST" action="{{ route('verification.send') }}" class="pt-4">
                    @csrf
                    <button type="submit" class="btn-primary w-full py-3.5 flex items-center justify-center gap-2 text-sm font-semibold transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89H18v3z"></path>
                        </svg>
                        Resend Verification Email
                    </button>
                </form>

                <!-- Back to Home or Logout -->
                <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-sm">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition-colors flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Home
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-red-500 transition-colors font-medium">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
