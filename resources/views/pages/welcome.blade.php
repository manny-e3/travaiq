@extends('layouts.app')

@section('title', 'Travaiq - AI-Powered Travel Planning')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center overflow-hidden bg-gradient-to-br from-white via-indigo-50/50 to-purple-50/50">
    <!-- Decorative Background -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary/5 to-transparent pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary/10 rounded-full blur-3xl opacity-50 pointer-events-none animate-pulse-slow"></div>
    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>

    <div class="container mx-auto px-4 py-12 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <!-- Left Content -->
            <div class="w-full lg:w-1/2 text-center lg:text-left">
                <div class="inline-flex items-center px-4 py-2 bg-white border border-gray-100 rounded-full shadow-sm mb-6 animate__animated animate__fadeInDown">
                    <span class="flex h-2 w-2 relative mr-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-accent"></span>
                    </span>
                    <span class="text-sm font-medium text-gray-600">AI-Powered Travel Planning</span>
                </div>
                
                <h1 class="text-5xl lg:text-7xl font-bold mb-6 text-gray-900 tracking-tight leading-tight animate__animated animate__fadeInUp">
                    Design Your <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-primary-light to-accent">Dream Trip</span>
                </h1>
                
                <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0 animate__animated animate__fadeInUp animate__delay-1s">
                    Create personalized itineraries in seconds. Our AI learns your style to recommend hidden gems, perfect hotels, and unforgettable experiences.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-12 animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="flex items-center bg-white/80 backdrop-blur-sm px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex -space-x-3 mr-3">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=1" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=2" alt="User">
                            <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=3" alt="User">
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">+2k</div>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-gray-900">10,000+</p>
                            <p class="text-xs text-gray-500">Trips Planned</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form (Glassmorphism) -->
            <div class="w-full lg:w-1/2 animate__animated animate__fadeInRight">
                <div class="relative max-w-md mx-auto">
                    <!-- Blur blobs behind form -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-primary to-accent rounded-2xl blur opacity-20"></div>
                    
                    <div class="glass rounded-2xl p-8 relative">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">Where to next?</h2>
                            <p class="text-gray-500">Start your journey in seconds</p>
                        </div>

                        <form action="{{route('createPlan')}}" method="GET" class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Destination</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text"
                                        id="location"
                                        name="location"
                                        required
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary focus:bg-white transition-all duration-200 sm:text-sm"
                                        placeholder="e.g. Paris, Tokyo, Bali"
                                        autocomplete="off">
                                    <div id="suggestions" class="absolute z-10 mt-1 w-full bg-white shadow-xl max-h-60 rounded-xl py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm d-none"></div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Travel Date</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="date" 
                                        name="travel_date" 
                                        required
                                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-gray-50/50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary focus:bg-white transition-all duration-200 sm:text-sm">
                                </div>
                            </div>

                            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-gradient-to-r from-primary to-primary-light hover:from-primary-dark hover:to-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transform transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                                Create My Itinerary
                            </button>
                        </form>

                        <div class="mt-6 flex items-center justify-center space-x-4 text-xs text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Free to use
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                No signup needed
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Bento Grid -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-5xl font-bold mb-6 text-gray-900">Why Travaiq?</h2>
            <p class="text-xl text-gray-500">More than just a planner. Experience the future of travel with our intelligent features.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[300px]">
            <!-- Large Feature -->
            <div class="md:col-span-2 row-span-1 bg-gray-50 rounded-3xl p-8 relative overflow-hidden group transition-all hover:shadow-lg border border-gray-100">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -mr-16 -mt-16 transition-all group-hover:bg-primary/10"></div>
                <div class="relative z-10 h-full flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-2xl mb-4 text-primary">
                            🧠
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Smart AI Personalization</h3>
                        <p class="text-gray-600 max-w-md">Our algorithms analyze your preferences to build unique trips. No two itineraries are the same.</p>
                    </div>
                    <!-- Minimal visual representation of AI graph or nodes -->
                    <div class="mt-4 flex gap-2 opacity-60">
                         <div class="h-2 w-12 bg-primary/20 rounded-full"></div>
                         <div class="h-2 w-20 bg-primary/20 rounded-full"></div>
                         <div class="h-2 w-8 bg-primary/20 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="md:col-span-1 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm relative overflow-hidden group hover:border-primary/30 transition-all">
                <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center text-2xl mb-4 text-accent">
                    ⚡
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Instant Results</h3>
                <p class="text-gray-600 text-sm">Get a complete day-by-day plan in seconds. Stop wasting hours on research.</p>
            </div>

            <!-- Feature 3 -->
            <div class="md:col-span-1 bg-white rounded-3xl p-8 border border-gray-100 shadow-sm relative overflow-hidden group hover:border-primary/30 transition-all">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl mb-4 text-green-600">
                    🌍
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Local Gems</h3>
                <p class="text-gray-600 text-sm">Discover authentic spots loved by locals, far from the tourist crowds.</p>
            </div>

            <!-- Feature 4 (Wide) -->
            <div class="md:col-span-2 bg-gradient-to-r from-gray-900 to-gray-800 rounded-3xl p-8 text-white relative overflow-hidden group">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 h-full">
                    <div class="flex-1">
                        <div class="inline-block px-3 py-1 bg-white/10 rounded-full text-xs font-semibold mb-4 backdrop-blur-sm">PRO FEATURE</div>
                        <h3 class="text-2xl font-bold mb-2">Export to Everywhere</h3>
                        <p class="text-gray-300 text-sm">Save your itinerary to PDF, Google Maps, or share with friends seamlessly.</p>
                    </div>
                    <div class="flex-shrink-0">
                         <a href="{{ route('createPlan') }}" class="bg-white text-gray-900 px-6 py-2 rounded-full font-bold text-sm hover:bg-gray-100 transition-colors">Try It Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section with Accordion -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900">Common Questions</h2>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @foreach([
                ['q' => 'Is Travaiq really free?', 'a' => 'Yes! You can generate standard itineraries completely for free without any hidden costs.'],
                ['q' => 'Can I customize the generated plan?', 'a' => 'Absolutely. Once the AI generates your plan, you can edit, remove, or swap any activity.'],
                ['q' => 'Do I need an account?', 'a' => 'No account is required to generate a plan. However, creating a free account allows you to save your trips.']
            ] as $index => $faq)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden transition-all duration-300" :class="active === {{$index}} ? 'shadow-md border-primary/30' : ''">
                <button @click="active === {{$index}} ? active = null : active = {{$index}}" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                    <span class="font-semibold text-gray-900">{{ $faq['q'] }}</span>
                    <span class="transition-transform duration-300" :class="active === {{$index}} ? 'rotate-180' : ''">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div x-show="active === {{$index}}" x-collapse class="px-6 pb-6 text-gray-600 text-sm border-t border-gray-50 pt-4">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Alpine.js CDN -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection

@guest
<!-- Google One Tap -->
<script src="https://accounts.google.com/gsi/client" async defer></script>
<div id="g_id_onload"
     data-client_id="{{ config('services.google.client_id') }}"
     data-callback="handleCredentialResponse"
     data-auto_prompt="true">
</div>
<script>
    function handleCredentialResponse(response) {
        fetch('/google-onetap-login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ credential: response.credential })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) { window.location.reload(); }
        })
        .catch(console.error);
    }
</script>
@endguest

<style>
    .d-none { display: none !important; }
    .show { display: block !important; }
    .suggestion-item { padding: 0.75rem 1rem; cursor: pointer; transition: background-color 0.2s; }
    .suggestion-item:hover { background-color: #f9fafb; } /* gray-50 */
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let searchTimeout;
        const $suggestionsContainer = $('#suggestions');
        const $locationInput = $('#location');

        $locationInput.on('input', function() {
            const searchTerm = $(this).val().trim();

            clearTimeout(searchTimeout);

            if (searchTerm.length < 2) {
                $suggestionsContainer.removeClass('show').addClass('d-none');
                return;
            }

            $suggestionsContainer
                .html(`
                    <div class="suggestion-item flex items-center space-x-2 animate-pulse text-gray-600" role="option">
                        <svg class="w-5 h-5 text-primary animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        <span>Loading suggestions...</span>
                    </div>
                `)
                .removeClass('d-none').addClass('show');

            searchTimeout = setTimeout(() => {
                $.get('/api/location-suggestions', {
                        term: searchTerm
                    })
                    .done(function(response) {
                        if (response && response.length > 0) {
                            let suggestionsHtml = '';
                            response.forEach(function(suggestion) {
                                suggestionsHtml += `<div class="suggestion-item" role="option">${suggestion.DisplayText}</div>`;
                            });
                            $suggestionsContainer.html(suggestionsHtml).removeClass('d-none').addClass('show');
                        } else {
                            $suggestionsContainer.html('<div class="suggestion-item" role="option">No results found</div>').addClass('show');
                        }
                    })
                    .fail(function() {
                        $suggestionsContainer.html('<div class="suggestion-item" role="option">Error loading suggestions</div>').addClass('show');
                    });
            }, 300);
        });

        // Handle click on suggestion
        $suggestionsContainer.on('click', '.suggestion-item', function() {
            $locationInput.val($(this).text());
            $suggestionsContainer.removeClass('show').addClass('d-none');
        });

        // Hide suggestions on outside click
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.form-group').length) {
                $suggestionsContainer.removeClass('show').addClass('d-none');
            }
        });
    });
</script>