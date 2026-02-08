@extends('layouts.app')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 min-w-0 max-w-full">
        <div class="max-w-screen-xl mx-auto">
            <!-- Hero Section -->
            {{-- mt-20 mb-12 sm:mb-20 --}}
            <section class="mb-12 lg:mb-24 pb-10 pt-10 " id="hero">
                <div class="container mx-auto text-center px-4">
                    <h4 class="feature-title">Tell us your travel preferences</h4>
                    <p class="feature-description"> Just provide some basic information, and our trip planner will
                        generate a customized itinerary based on your preferences.</p>
                </div>

                <form action="{{ route('travel.generate') }}" id="travelForm" method="POST" class="space-y-6"
                    onsubmit="return validateForm()">
                    @csrf

                    <!-- Destination -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">What is destination of
                            choice?*</label>
                        <input type="text" required id="location" name="location"
                            class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter City, Airport, or Address">

                    </div>

                    <!-- Travel Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">When are you planning to
                            travel?*</label>
                        <input type="date" name="travel" required placeholder="dd/mm/yyyy"
                            class="w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">How many days are you planning
                            to travel?*</label>
                        <div class="flex items-center">
                            <span class="text-sm font-medium mr-2">Day</span>
                            <button type="button" onclick="decrementDays()"
                                class="px-3 py-1 border border-gray-300 rounded-l bg-white hover:bg-gray-50">-</button>
                            <input type="number" value="3" id="daysInput" name="duration" min="1"
                                max="5" required
                                class="w-16 text-center border-y border-gray-300 py-1 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" />
                            <button type="button" onclick="incrementDays()"
                                class="px-3 py-1 border border-gray-300 rounded-r bg-white hover:bg-gray-50">+</button>
                        </div>
                    </div>

                    <!-- Budget -->
                    <div>
                        <input type="hidden" name="budget" id="budgetInput" required>
                        <label class="block text-sm font-medium text-gray-700 mb-1">What is Your Budget?*</label>
                        <p class="text-xs text-gray-500 mb-3">The budget is exclusively allocated for activities
                            and dining purposes.</p>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="budget-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="setBudget('low')">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="6" width="18" height="12" rx="2" stroke-width="2" />
                                        <path d="M7 12h10" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Low</div>
                                <p class="text-xs text-gray-500">0 - 1000 USD</p>
                            </div>
                            <div class="budget-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="setBudget('medium')">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="6" width="18" height="12" rx="2" stroke-width="2" />
                                        <path d="M12 8v8M8 12h8" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Medium</div>
                                <p class="text-xs text-gray-500">1000 - 2500 USD</p>
                            </div>
                            <div class="budget-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="setBudget('high')">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="6" width="18" height="12" rx="2" stroke-width="2" />
                                        <path d="M12 8v8M8 12h8M16 10l-8 4" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>High</div>
                                <p class="text-xs text-gray-500">2500+ USD</p>
                            </div>
                        </div>
                    </div>

                    <!-- Companions -->
                    <div>
                        <input type="hidden" name="traveler" id="companionInput" required>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Who do you plan on traveling
                            with on your next adventure?</label>
                        <div class="grid grid-cols-4 gap-4">
                            <div class="companion-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="setCompanion('Solo')">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <circle cx="12" cy="8" r="4" stroke-width="2" />
                                        <path d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Solo</div>
                            </div>
                            <div class="companion-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="setCompanion('Couple')">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <circle cx="9" cy="8" r="3" stroke-width="2" />
                                        <circle cx="15" cy="8" r="3" stroke-width="2" />
                                        <path d="M4 21v-2a4 4 0 014-4h8a4 4 0 014 4v2" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Couple</div>
                            </div>
                            <div class="companion-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="setCompanion('Family')">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <circle cx="12" cy="6" r="3" stroke-width="2" />
                                        <circle cx="7" cy="13" r="2" stroke-width="2" />
                                        <circle cx="17" cy="13" r="2" stroke-width="2" />
                                        <path d="M5 21v-2a3 3 0 013-3h8a3 3 0 013 3v2" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Family</div>
                            </div>
                            <div class="companion-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="setCompanion('Friends')">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <circle cx="7" cy="8" r="3" stroke-width="2" />
                                        <circle cx="17" cy="8" r="3" stroke-width="2" />
                                        <path d="M3 21v-2a4 4 0 014-4h2m8 0h2a4 4 0 014 4v2" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Friends</div>
                            </div>
                        </div>
                    </div>

                    <!-- Activities -->
                    <div>
                        <input type="hidden" name="activities" id="activitiesInput" required>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Which activities are you
                            interested in?</label>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="activity-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="toggleActivity('Beaches')" data-activity="Beaches">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <path d="M13 21H3m18-4H3m18-4H3m18-4H3M21 5H3" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Beaches</div>
                            </div>
                            <div class="activity-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="toggleActivity('City sightseeing')" data-activity="City sightseeing">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <path d="M3 21h18M3 7v14m18-14v14M6 21V11m4 10V11m4 10V7m4 14V11"
                                            stroke-width="2" />
                                    </svg>
                                </div>
                                <div>City sightseeing</div>
                            </div>
                            <div class="activity-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="toggleActivity('Outdoor adventures')" data-activity="Outdoor adventures">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <path d="M8 3h8l4 8-10 3L4 11l4-8z" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Outdoor adventures</div>
                            </div>
                            <div class="activity-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="toggleActivity('Festivals/events')" data-activity="Festivals/events">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12"
                                            stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Festivals/events</div>
                            </div>
                            <div class="activity-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="toggleActivity('Food exploration')" data-activity="Food exploration">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <path d="M3 6h18M3 12h18M3 18h18" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Food exploration</div>
                            </div>
                            <div class="activity-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="toggleActivity('Nightlife')" data-activity="Nightlife">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <path d="M12 3a6 6 0 016 6c0 7-6 11-6 11s-6-4-6-11a6 6 0 016-6z"
                                            stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Nightlife</div>
                            </div>
                            <div class="activity-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="toggleActivity('Shopping')" data-activity="Shopping">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Shopping</div>
                            </div>
                            <div class="activity-option border border-gray-300 rounded-md p-4 text-center cursor-pointer hover:border-indigo-500 hover:bg-gray-50"
                                onclick="toggleActivity('Spa wellness')" data-activity="Spa wellness">
                                <div class="mb-2">
                                    <svg class="w-6 h-6 mx-auto" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor">
                                        <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9-9 9-9-1.8-9-9 1.8-9 9-9z" stroke-width="2" />
                                    </svg>
                                </div>
                                <div>Spa wellness</div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end mt-6">
                        <button type="submit" id="submitBtn"
                            class="bg-black text-white px-4 py-2 rounded flex items-center">
                            <span id="submitText">Generate</span>
                            <svg id="spinner" class="hidden ml-2 h-5 w-5 animate-spin" viewBox="0 0 24 24"
                                fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
                <div id="overlay"
                    class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-white p-8 rounded-lg shadow-xl text-center w-96">
                        <p class="text-2xl font-semibold text-blue-600">Generating your plan...</p>
                        <p class="text-md text-gray-700 mt-4">This may take a few seconds.</p>
                        <div class="mt-6">
                            <p class="text-sm text-gray-600">We are processing your travel preferences and generating the
                                best possible plan for you.</p>
                            <p class="text-sm text-gray-600 mt-2">Please be patient as this process takes a moment.</p>
                        </div>
                        <div class="mt-8">
                            <div class="spinner-border animate-spin inline-block w-12 h-12 border-4 border-solid border-blue-500 border-t-transparent rounded-full"
                                role="status">
                                <span class="visually-hidden"></span>
                            </div>
                        </div>
                    </div>
                </div>


            </section>


        </div>
    </main>
@endsection
