<footer class="bg-gray-900 text-white relative mt-auto">
    <!-- Gradient Line -->
    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-primary via-accent to-primary-light"></div>
    
    <div class="container mx-auto px-4 pt-16 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <!-- Brand Column -->
            <div class="space-y-6 lg:col-span-1">
                <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                    <img height="28" width="28" src="{{ asset('travaiqlogo.png') }}" alt="Travaiq" class="h-7 w-7">
                    <span class="text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-primary-light to-accent">TravaiQ</span>
                </a>
                <p class="text-gray-400 leading-relaxed text-sm">
                    AI-powered travel planning that creates personalized itineraries in seconds. Discover hidden gems, book real hotels, and plan unforgettable adventures.
                </p>
                <div class="flex space-x-3">
                    <a href="https://www.instagram.com/travaiq" target="_blank" rel="noopener" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-xl flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg group" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="text-gray-400 group-hover:text-white transition-colors" viewBox="0 0 16 16">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                        </svg>
                    </a>
                    <a href="https://twitter.com/travaiq" target="_blank" rel="noopener" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-xl flex items-center justify-center transition-all duration-300 hover:-translate-y-1 hover:shadow-lg group" aria-label="Twitter/X">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-gray-400 group-hover:text-white transition-colors" viewBox="0 0 16 16">
                            <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Product Links -->
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-300 mb-6">Product</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('createPlan') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
                        <svg class="w-3.5 h-3.5 text-primary opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Trip Planner
                    </a></li>
                    <li><a href="{{ route('travel.guide') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
                        <svg class="w-3.5 h-3.5 text-primary opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Travel Guide
                    </a></li>
                    <li><a href="{{ route('public.trip.index') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
                        <svg class="w-3.5 h-3.5 text-primary opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Browse Itineraries
                    </a></li>
                </ul>
            </div>
            
            <!-- Company Links -->
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-300 mb-6">Company</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
                        <svg class="w-3.5 h-3.5 text-primary opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        About Us
                    </a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
                        <svg class="w-3.5 h-3.5 text-primary opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Contact
                    </a></li>
                    <li><a href="{{ route('faqs') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
                        <svg class="w-3.5 h-3.5 text-primary opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        FAQs
                    </a></li>
                </ul>
            </div>
            
            <!-- Legal Links -->
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-gray-300 mb-6">Legal</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('privacy.policy') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
                        <svg class="w-3.5 h-3.5 text-primary opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Privacy Policy
                    </a></li>
                    <li><a href="{{ route('terms.of.service') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
                        <svg class="w-3.5 h-3.5 text-primary opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Terms of Service
                    </a></li>
                    <li><a href="{{ route('cookie.policy') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm flex items-center gap-2 group">
                        <svg class="w-3.5 h-3.5 text-primary opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        Cookie Policy
                    </a></li>
                </ul>
            </div>
        </div>
        
        <!-- Divider -->
        <div class="h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent mb-8"></div>
        
        <!-- Bottom Bar -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-gray-500 text-sm text-center md:text-left">
                &copy; @php echo date('Y'); @endphp TravaiQ. All rights reserved. Made with 
                <span class="text-red-400">♥</span> and AI.
            </p>
            
            <div class="flex items-center gap-6">
                <a href="{{ route('sitemap') }}" class="text-gray-500 hover:text-white transition-colors duration-200 text-sm">Sitemap</a>
                <span class="text-gray-700">·</span>
                <span class="text-gray-500 text-sm flex items-center gap-1.5">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    All systems operational
                </span>
            </div>
        </div>
    </div>
</footer>
