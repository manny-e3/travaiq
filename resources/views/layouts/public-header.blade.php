<header class="sticky top-0 z-50 glass transition-all duration-300">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex flex-wrap items-center justify-between">
            <!-- Brand -->
            <a href="{{url('/')}}" class="flex items-center gap-2 group">
                <img height="32" src="{{ asset('travaiqlogo.png') }}" alt="Travaiq Logo" class="h-8 w-auto object-contain transition-transform transform group-hover:scale-110">
                <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-primary-light">TravaiQ</span>
            </a>
            
            <!-- Mobile Menu Button -->
            <div class="block lg:hidden">
                <button id="menu-toggle" class="flex items-center px-3 py-2 text-primary hover:text-primary-dark transition-colors focus:outline-none">
                    <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                    </svg>
                </button>
            </div>
            
            <!-- Navigation Links -->
            <div id="menu" class="hidden w-full lg:flex lg:items-center lg:w-auto mt-4 lg:mt-0 transition-all duration-300">
                <div class="flex flex-col lg:flex-row lg:items-center gap-4 lg:gap-8 text-sm font-medium">
                    <a href="{{ route('travel.guide') }}" class="text-gray-600 hover:text-primary transition-colors hover:scale-105 transform">
                        Travel Guide
                    </a>
                    <a href="{{ route('createPlan') }}" class="text-gray-600 hover:text-primary transition-colors hover:scale-105 transform">
                        Trip Planner
                    </a>
                    @if (Auth::check())
                        {{-- My Trips link can go here if needed directly --}}
                    @endif
                </div>

                <!-- Auth Buttons -->
                <div class="flex flex-col lg:flex-row items-start lg:items-center mt-4 lg:mt-0 lg:ml-8 gap-4">
                    @if (Auth::check())
                        <div class="relative group">
                            <!-- User Profile Dropdown Trigger -->
                            <button id="user-menu-button" class="flex items-center focus:outline-none space-x-2">
                                <img class="h-9 w-9 rounded-full object-cover border-2 border-primary/20 ring-2 ring-transparent group-hover:ring-primary/20 transition-all"
                                    src="{{ Auth::user()->picture ?? asset('user.png') }}"
                                    alt="User profile">
                                <span class="hidden lg:block text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 text-gray-500 transition-transform group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 border border-gray-100 z-50 transform origin-top-right transition-all duration-200">
                                <a href="{{ route('my.trips') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">
                                    My Trips
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('loginRegister') }}" class="btn-primary flex items-center gap-2">
                            <span>Sign In</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
    // Simple toggle logic for mobile menu and user dropdown
    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('menu');
        const userMenuBtn = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        if (menuToggle && menu) {
            menuToggle.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }

        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
