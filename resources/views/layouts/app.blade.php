<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title Tag (max ~60 characters) -->
    <title>@yield('title', 'Travaiq - AI-Powered Travel Planning')</title>

    <!-- Meta Description (max ~160 characters) -->
    <meta name="description" content="Get in touch with Travaiq for travel inquiries, partnership opportunities, and support. We're here to help plan your next adventure.">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://www.travaiq.com/contact" />

    <!-- Open Graph Tags (for better social sharing) -->
    <meta property="og:title" content="Contact Us - Travaiq" />
    <meta property="og:description" content="Have questions? Contact Travaiq for travel support, partnerships, and more." />
    <meta property="og:image" content="https://www.travaiq.com/images/contact-banner.jpg" />
    <meta property="og:url" content="https://www.travaiq.com/contact" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Contact Us - Travaiq" />
    <meta name="twitter:description" content="Reach out to Travaiq for travel help, partnerships, and questions." />
    <meta name="twitter:image" content="https://www.travaiq.com/images/contact-banner.jpg" />

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('travaiqlogo.png') }}" type="image/x-icon" />

    <!-- Robots tag (ensure page is indexable) -->
    <meta name="robots" content="index, follow" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-800 bg-gray-50 overflow-x-hidden flex flex-col min-h-screen">
    <!-- Background Elements -->
    <div class="fixed top-1/4 -left-32 w-64 h-64 bg-primary rounded-full opacity-10 blur-3xl pointer-events-none"></div>
    <div class="fixed bottom-1/4 -right-32 w-64 h-64 bg-accent rounded-full opacity-10 blur-3xl pointer-events-none"></div>
    
    @include('layouts.public-header')

    <main class="flex-grow relative z-10">
        @yield('content')
    </main>

    @include('layouts.public-footer')

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KBCRTSETD9"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-KBCRTSETD9');
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initAutocomplete"
        async defer></script>
</body>
</html>       
