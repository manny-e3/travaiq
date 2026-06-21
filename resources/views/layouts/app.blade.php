<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title', 'TravaiQ — AI-Powered Travel Planning')</title>

    <!-- Meta Description -->
    <meta name="description" content="@yield('meta_description', 'Plan your dream trip with AI. TravaIQ creates personalized day-by-day itineraries with real hotel recommendations, hidden gems, and local experiences — for free.')">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', 'TravaiQ — AI-Powered Travel Planning')" />
    <meta property="og:description" content="@yield('og_description', 'Create personalized travel itineraries in seconds. Real hotels, hidden gems, and local experiences — powered by AI.')" />
    <meta property="og:image" content="@yield('og_image', asset('travaiqlogo.png'))" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="TravaiQ" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('og_title', 'TravaiQ — AI-Powered Travel Planning')" />
    <meta name="twitter:description" content="@yield('og_description', 'Create personalized travel itineraries in seconds with AI.')" />
    <meta name="twitter:image" content="@yield('og_image', asset('travaiqlogo.png'))" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('travaiqlogo.png') }}" type="image/png" />
    <link rel="apple-touch-icon" href="{{ asset('travaiqlogo.png') }}" />

    <!-- Robots -->
    <meta name="robots" content="index, follow" />

    <!-- Theme Color -->
    <meta name="theme-color" content="#7c3aed" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page-specific styles -->
    @yield('styles')
</head>
<body class="font-sans text-gray-800 bg-white overflow-x-hidden flex flex-col min-h-screen antialiased">
    <!-- Background Decorative Elements -->
    <div class="fixed top-1/4 -left-32 w-64 h-64 bg-primary rounded-full opacity-[0.04] blur-3xl pointer-events-none"></div>
    <div class="fixed bottom-1/4 -right-32 w-64 h-64 bg-accent rounded-full opacity-[0.04] blur-3xl pointer-events-none"></div>
    
    @include('layouts.public-header')

    <main class="flex-grow relative z-10">
        @yield('content')
    </main>

    @include('layouts.public-footer')

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KBCRTSETD9"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-KBCRTSETD9');
    </script>

    <!-- Google Maps (only load on pages that need it) -->
    @yield('scripts')
</body>
</html>       
