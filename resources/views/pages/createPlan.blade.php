@extends('layouts.app')

@section('title', 'Create Travel Plan - Travaiq')

@section('content')

    <!-- Hero Section -->
    <section class="relative py-16 bg-gradient-to-br from-primary via-primary-dark to-purple-900 text-white overflow-hidden">
        <!-- Abstract Background Shapes -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 rounded-full bg-accent opacity-10 blur-3xl pointer-events-none"></div>
        
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight animate__animated animate__fadeInDown">
                Plan Your Perfect Trip
            </h1>
            <p class="text-xl text-indigo-100 max-w-2xl mx-auto mb-8 animate__animated animate__fadeInUp animate__delay-1s">
                Tell us your preferences and let our AI craft a personalized itinerary in seconds.
            </p>
            
            <!-- Progress Steps (Visual only for now) -->
            <div class="flex items-center justify-center space-x-4 text-sm font-medium opacity-80 animate__animated animate__fadeIn animate__delay-2s">
                <div class="flex items-center text-accent">
                    <span class="w-6 h-6 rounded-full bg-accent text-primary-dark flex items-center justify-center mr-2 text-xs font-bold">1</span>
                    Preferences
                </div>
                <div class="w-12 h-0.5 bg-white/20"></div>
                <div class="flex items-center text-white/50">
                    <span class="w-6 h-6 rounded-full bg-white/10 flex items-center justify-center mr-2 text-xs">2</span>
                    Itinerary
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="relative z-10 -mt-10 pb-24">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden animate__animated animate__fadeInUp" id="plan-form">
                    
                    @if(request('travel_date'))
                    <div class="bg-green-50 border-b border-green-100 p-4">
                        <div class="flex items-center text-green-800">
                            <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>
                                <span class="font-bold">Great start!</span> Planning for <span class="font-bold">{{ request('location') }}</span> on {{ \Carbon\Carbon::parse(request('travel_date'))->format('M d, Y') }}.
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="p-8 md:p-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Trip Preferences</h2>
                        <p class="text-gray-500 mb-10">Customize your experience to match your travel style.</p>

                        <form action="{{ route('travel.generate') }}" id="travelForm" method="POST" onsubmit="return validateForm()" class="space-y-10">
                            @csrf
                            
                            <!-- Destination & Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Destination -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Destination</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <input type="text"
                                            class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary focus:bg-white transition-all duration-200"
                                            id="location"
                                            name="location"
                                            value="{{ request('location', '') }}"
                                            placeholder="Where do you want to go?"
                                            autocomplete="off"
                                            required>
                                        <div id="suggestions" class="absolute z-50 mt-1 w-full bg-white shadow-xl max-h-60 rounded-xl py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm d-none"></div>
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="date" 
                                            name="travel" 
                                            value="{{ request('travel_date', '') }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary focus:bg-white transition-all duration-200"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <!-- Duration Counter -->
                            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div>
                                    <label class="block text-base font-semibold text-gray-900 mb-1">Trip Duration</label>
                                    <p class="text-sm text-gray-500">How many days will you be exploring?</p>
                                </div>
                                <div class="flex items-center bg-white rounded-full shadow-sm border border-gray-200 p-1">
                                    <button type="button" onclick="decrementDays()" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-primary transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                    <input type="number" value="3" id="daysInput" name="duration" min="1" max="5" required readonly
                                        class="w-12 text-center text-lg font-bold text-gray-900 border-none p-0 focus:ring-0" />
                                    <span class="text-sm text-gray-400 font-medium mr-2">Days</span>
                                    <button type="button" onclick="incrementDays()" class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-100 hover:text-primary transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Budget Selection -->
                            <div class="space-y-4">
                                <label class="block text-lg font-semibold text-gray-900">Estimated Budget <span class="text-sm font-normal text-gray-400 ml-2">(Excluding flights & accommodation)</span></label>
                                <input type="hidden" name="budget" id="budgetInput" required>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach([
                                        ['id' => 'low', 'label' => 'Economy', 'range' => '$0 - $1,000', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        ['id' => 'medium', 'label' => 'Standard', 'range' => '$1,000 - $2,500', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                                        ['id' => 'high', 'label' => 'Luxury', 'range' => '$2,500+', 'icon' => 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7']
                                    ] as $budget)
                                    <div class="budget-option relative p-6 rounded-2xl border-2 border-gray-100 cursor-pointer transition-all duration-200 hover:border-primary/50 hover:bg-gray-50 group bg-white"
                                         onclick="setBudget('{{ $budget['id'] }}')">
                                        <div class="flex flex-col items-center text-center">
                                            <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $budget['icon'] }}"></path></svg>
                                            </div>
                                            <h3 class="font-bold text-gray-900 group-hover:text-primary transition-colors">{{ $budget['label'] }}</h3>
                                            <p class="text-xs text-gray-500 mt-1">{{ $budget['range'] }}</p>
                                        </div>
                                        <!-- Checkmark -->
                                        <div class="absolute top-4 right-4 text-primary opacity-0 check-mark transition-opacity">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Companions Selection -->
                            <div class="space-y-4">
                                <label class="block text-lg font-semibold text-gray-900">Who are you traveling with?</label>
                                <input type="hidden" name="traveler" id="companionInput" required>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach([
                                        ['id' => 'Solo', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                        ['id' => 'Couple', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                                        ['id' => 'Family', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                                        ['id' => 'Friends', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z']
                                    ] as $comp)
                                    <div class="companion-option relative p-4 rounded-xl border-2 border-gray-100 cursor-pointer transition-all duration-200 hover:border-primary/50 hover:bg-gray-50 group bg-white text-center"
                                         onclick="setCompanion('{{ $comp['id'] }}')">
                                        <div class="mx-auto w-10 h-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center mb-3 group-hover:bg-primary group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $comp['icon'] }}"></path></svg>
                                        </div>
                                        <span class="font-medium text-gray-700 group-hover:text-gray-900">{{ $comp['id'] }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Activities Selection -->
                            <div class="space-y-4">
                                <label class="block text-lg font-semibold text-gray-900">Interests & Activities</label>
                                <input type="hidden" name="activities" id="activitiesInput" required>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                    @foreach([
                                        'Beaches', 'City sightseeing', 'Outdoor adventures', 'Festivals/events',
                                        'Food exploration', 'Nightlife', 'Shopping', 'Spa wellness'
                                    ] as $activity)
                                    <div class="activity-option px-4 py-3 rounded-xl border border-gray-200 cursor-pointer transition-all duration-200 hover:border-primary/50 hover:bg-purple-50 hover:text-primary text-gray-600 bg-white text-center text-sm font-medium"
                                         onclick="toggleActivity('{{ $activity }}')" 
                                         data-activity="{{ $activity }}">
                                        {{ $activity }}
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- User Location Data (Hidden) -->
                            <div id="locationDataInputs">
                                <input type="hidden" name="country" id="user_country">
                                <input type="hidden" name="city" id="user_city">
                                <input type="hidden" name="ip" id="user_ip">
                                <input type="hidden" name="longitude" id="user_longitude">
                                <input type="hidden" name="latitude" id="user_latitude">
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-8">
                                <button type="submit" id="submitBtn" class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-primary to-primary-light text-white font-bold text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transform transition-all duration-300 flex items-center justify-center group">
                                    <span id="submitText">Generate My Dream Itinerary</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Generating Overlay -->
    <div id="overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-white/90 backdrop-blur-md">
        <div class="text-center max-w-md px-8 animate__animated animate__fadeInUp">
            <div class="relative w-24 h-24 mx-auto mb-8">
                <div class="absolute inset-0 border-4 border-gray-200 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-primary rounded-full border-t-transparent animate-spin"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Designing Your Trip</h3>
            <p class="text-gray-500 mb-6" id="progressStatus">Analyzing preferences...</p>
            
            <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden mb-2">
                <div class="h-full bg-primary rounded-full transition-all duration-500 ease-out" id="progressBar" style="width: 0%"></div>
            </div>
            <p class="text-sm font-medium text-primary mt-2" id="progressCounter">0%</p>
        </div>
    </div>

    <!-- Scripts -->
    <style>
        .d-none { display: none !important; }
        .show { display: block !important; }
        .suggestion-item { padding: 0.75rem 1rem; cursor: pointer; transition: background-color 0.2s; }
        .suggestion-item:hover { background-color: #f9fafb; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // State Management
        let selectedBudget = null;
        let selectedCompanion = null;
        let selectedActivities = [];

        // UI Helpers
        function decrementDays() {
            const input = document.getElementById('daysInput');
            if (input.value > input.min) input.value = parseInt(input.value) - 1;
        }

        function incrementDays() {
            const input = document.getElementById('daysInput');
            if (input.value < input.max) input.value = parseInt(input.value) + 1;
        }

        function setBudget(budget) {
            selectedBudget = budget;
            document.getElementById('budgetInput').value = budget;
            
            // Updates styles
            document.querySelectorAll('.budget-option').forEach(el => {
                el.classList.remove('border-primary', 'bg-purple-50', 'ring-1', 'ring-primary');
                el.querySelector('.check-mark').classList.remove('opacity-100');
            });
            
            const activeEl = document.querySelector(`.budget-option[onclick="setBudget('${budget}')"]`);
            activeEl.classList.add('border-primary', 'bg-purple-50', 'ring-1', 'ring-primary');
            activeEl.querySelector('.check-mark').classList.add('opacity-100');
        }

        function setCompanion(companion) {
            selectedCompanion = companion;
            document.getElementById('companionInput').value = companion;

            document.querySelectorAll('.companion-option').forEach(el => {
                el.classList.remove('border-primary', 'bg-purple-50', 'ring-1', 'ring-primary');
                el.querySelector('div').classList.remove('bg-primary', 'text-white');
                el.querySelector('div').classList.add('bg-gray-100', 'text-gray-500');
            });

            const activeEl = document.querySelector(`.companion-option[onclick="setCompanion('${companion}')"]`);
            activeEl.classList.add('border-primary', 'bg-purple-50', 'ring-1', 'ring-primary');
            activeEl.querySelector('div').classList.remove('bg-gray-100', 'text-gray-500');
            activeEl.querySelector('div').classList.add('bg-primary', 'text-white');
        }

        function toggleActivity(activity) {
            const el = document.querySelector(`.activity-option[data-activity="${activity}"]`);
            
            if (selectedActivities.includes(activity)) {
                selectedActivities = selectedActivities.filter(a => a !== activity);
                el.classList.remove('border-primary', 'bg-primary', 'text-white');
                el.classList.add('border-gray-200', 'text-gray-600', 'bg-white');
            } else {
                selectedActivities.push(activity);
                el.classList.remove('border-gray-200', 'text-gray-600', 'bg-white');
                el.classList.add('border-primary', 'bg-primary', 'text-white');
            }
            document.getElementById('activitiesInput').value = JSON.stringify(selectedActivities);
        }

        function validateForm() {
            // Validation Logic
            if (!selectedBudget) { showAlert('Please select a budget range'); return false; }
            if (!selectedCompanion) { showAlert('Please select your companions'); return false; }
            if (selectedActivities.length === 0) { showAlert('Select at least one activity'); return false; }

            // Show Overlay
            document.getElementById('overlay').classList.remove('hidden');
            startProgress();
            return true;
        }

        // Animated Progress
        function startProgress() {
            let progress = 0;
            const stages = [
                { p: 15, t: 'Analyzing location...' },
                { p: 30, t: 'Checking weather patterns...' },
                { p: 50, t: 'Finding hidden gems...' },
                { p: 70, t: 'Curating attractions...' },
                { p: 90, t: 'Finalizing your plan...' }
            ];
            
            let stageIdx = 0;
            const interval = setInterval(() => {
                if (progress < 95) {
                    progress += Math.random() * 2;
                    document.getElementById('progressBar').style.width = `${progress}%`;
                    document.getElementById('progressCounter').innerText = `${Math.floor(progress)}%`;
                    
                    if (stageIdx < stages.length && progress > stages[stageIdx].p) {
                        document.getElementById('progressStatus').innerText = stages[stageIdx].t;
                        stageIdx++;
                    }
                } else {
                    clearInterval(interval);
                }
            }, 100);
        }

        function showAlert(msg) {
            const div = document.createElement('div');
            div.className = 'fixed top-6 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-full shadow-lg z-50 animate__animated animate__fadeInDown font-medium flex items-center';
            div.innerHTML = `<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${msg}`;
            document.body.appendChild(div);
            setTimeout(() => {
                div.classList.replace('animate__fadeInDown', 'animate__fadeOutUp');
                setTimeout(() => div.remove(), 500);
            }, 3000);
        }

        // Auto-Suggestions
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
                if (!$(e.target).closest('.group').length) {
                    $suggestionsContainer.removeClass('show').addClass('d-none');
                }
            });
        });

        // Location Detection (Simplified)
        class CountryDetector {
            async detect() {
                try {
                    const resp = await fetch('https://ipapi.co/json/');
                    const data = await resp.json();
                    if (data.country_name) {
                        $('#user_country').val(data.country_name);
                        $('#user_city').val(data.city);
                        $('#user_ip').val(data.ip);
                    }
                } catch(e) { console.warn('Loc detection failed', e); }
            }
        }
        new CountryDetector().detect();
    </script>
@endsection