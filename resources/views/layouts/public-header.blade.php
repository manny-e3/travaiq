<header id="main-header" class="sticky top-0 z-50 transition-all duration-300 bg-white/80 backdrop-blur-xl border-b border-gray-100/50">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex flex-wrap items-center justify-between">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                <img height="32" width="32" src="{{ asset('travaiqlogo.png') }}" alt="Travaiq Logo" class="h-8 w-auto object-contain transition-transform transform group-hover:scale-110">
                <span class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-primary to-primary-light">TravaiQ</span>
            </a>
            
            <!-- Mobile Menu Button -->
            <div class="block lg:hidden">
                <button id="menu-toggle" class="flex items-center p-2 text-gray-600 hover:text-primary rounded-lg hover:bg-gray-100 transition-all focus:outline-none" aria-label="Toggle menu">
                    <svg id="menu-icon-open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="menu-icon-close" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Navigation Links -->
            <div id="menu" class="hidden w-full lg:flex lg:items-center lg:w-auto mt-4 lg:mt-0 transition-all duration-300">
                <div class="flex flex-col lg:flex-row lg:items-center gap-1 lg:gap-1 text-sm font-medium">
                    <a href="{{ route('createPlan') }}" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-primary/5 rounded-lg transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Trip Planner
                    </a>
                    <a href="{{ route('travel.guide') }}" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-primary/5 rounded-lg transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Travel Guide
                    </a>
                    <a href="{{ route('about') }}" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-primary/5 rounded-lg transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        About
                    </a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-primary/5 rounded-lg transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Contact
                    </a>
                </div>

                <!-- Auth Section -->
                <div class="flex flex-col lg:flex-row items-start lg:items-center mt-4 lg:mt-0 lg:ml-6 gap-3">
                    @if (Auth::check())
                        <div class="relative" x-data="{ open: false }">
                            <!-- User Profile Dropdown Trigger -->
                            <button @click="open = !open" class="flex items-center focus:outline-none gap-2.5 px-3 py-1.5 rounded-full hover:bg-gray-100 transition-all" id="user-menu-button">
                                <img class="h-8 w-8 rounded-full object-cover border-2 border-primary/20 ring-2 ring-transparent hover:ring-primary/20 transition-all"
                                    src="{{ Auth::user()->picture ?? asset('user.png') }}"
                                    alt="Profile">
                                <span class="hidden lg:block text-sm text-gray-700 font-semibold max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-1"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl py-2 border border-gray-100 z-50" 
                                 id="user-dropdown" style="display: none;">
                                
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                
                                <a href="{{ route('createPlan') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-primary/5 hover:text-primary transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    New Trip
                                </a>
                                <a href="{{ route('my.trips') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-primary/5 hover:text-primary transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    My Trips
                                </a>
                                
                                <div class="border-t border-gray-100 mt-1 pt-1">
                                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('loginRegister') }}" class="btn-primary flex items-center gap-2 text-sm">
                            <span>Sign In</span>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </nav>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');

        if (menuToggle && menu) {
            menuToggle.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                iconOpen.classList.toggle('hidden');
                iconClose.classList.toggle('hidden');
            });
        }

        // Header scroll effect
        const header = document.getElementById('main-header');
        let lastScroll = 0;
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 10) {
                header.classList.add('shadow-md');
                header.classList.remove('border-b', 'border-gray-100/50');
            } else {
                header.classList.remove('shadow-md');
                header.classList.add('border-b', 'border-gray-100/50');
            }
            
            lastScroll = currentScroll;
        }, { passive: true });
    });
</script>
