@extends('layouts.app')

@section('title', 'Profile Settings — TravaiQ')

@section('content')
<main class="flex-grow bg-gray-50/50 min-h-screen py-12 px-4 sm:px-6 lg:px-8 relative">
    <!-- Decorative background elements -->
    <div class="fixed top-1/4 -left-32 w-96 h-96 bg-primary rounded-full opacity-[0.03] blur-3xl pointer-events-none"></div>
    <div class="fixed bottom-1/4 -right-32 w-96 h-96 bg-accent rounded-full opacity-[0.03] blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto space-y-8 relative z-10">
        <!-- Title Section -->
        <div class="animate-fade-in-down">
            <h1 class="text-3xl font-extrabold text-gray-900 font-heading">
                Account <span class="text-gradient">Settings</span>
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Update your account details, change your password, and customize your profile.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Panel: Avatar Card -->
            <div class="space-y-6 animate-fade-in-left">
                <div class="glass-card p-6 text-center shadow-lg">
                    <!-- Profile Picture -->
                    <div class="relative w-32 h-32 mx-auto mb-4 group">
                        <img id="avatar-preview" src="{{ $user->picture ? asset($user->picture) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '?d=mp&s=150' }}" 
                             alt="{{ $user->name }}" 
                             class="w-full h-full object-cover rounded-full border-4 border-white shadow-md">
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $user->name }}</h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $user->email }}</p>
                    
                    <!-- Stats Badge -->
                    <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-around text-center">
                        <div>
                            <span class="block text-xl font-extrabold text-primary">{{ \App\Models\TripDetail::where('user_id', $user->id)->count() }}</span>
                            <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Trips</span>
                        </div>
                        <div class="w-px h-8 bg-gray-100"></div>
                        <div>
                            <span class="block text-xl font-extrabold text-accent">{{ $user->favorites()->count() }}</span>
                            <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Favorites</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Profile Details Settings Form -->
            <div class="md:col-span-2 space-y-6 animate-scale-in">
                <!-- Notifications -->
                @if (session('success'))
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm font-medium text-emerald-800">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 rounded-xl bg-red-50 border border-red-100 space-y-2">
                        @foreach ($errors->all() as $error)
                            <div class="text-sm font-medium text-red-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                {{ $error }}
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="glass-card p-8 shadow-lg">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Account Details Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                                <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" 
                                       class="input-modern" placeholder="John Doe">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                                <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" 
                                       class="input-modern" placeholder="john@example.com">
                            </div>
                        </div>

                        <!-- Profile Picture Upload -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Upload Avatar Picture</label>
                            <div class="flex items-center gap-4">
                                <input type="file" name="picture" id="picture" accept="image/*" class="hidden" onchange="previewImage(event)">
                                <label for="picture" class="btn-secondary cursor-pointer py-2.5 px-4 text-xs font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Choose Photo
                                </label>
                                <span id="file-chosen" class="text-xs text-gray-400">No file chosen</span>
                            </div>
                        </div>

                        <!-- Password Change section -->
                        <div class="pt-6 border-t border-gray-100 space-y-6">
                            <h3 class="text-lg font-bold text-gray-900">Change Password</h3>
                            <p class="text-xs text-gray-400 -mt-2">Leave blank if you don't want to change your password.</p>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Password -->
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">New Password</label>
                                    <input type="password" name="password" id="password" 
                                           class="input-modern" placeholder="••••••••">
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="input-modern" placeholder="••••••••">
                                </div>
                            </div>
                        </div>

                        <!-- Action buttons -->
                        <div class="pt-6 border-t border-gray-100 flex justify-end gap-4">
                            <a href="{{ route('my.trips') }}" class="btn-secondary py-3 px-6 text-sm font-semibold">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary py-3 px-8 text-sm font-semibold shadow-lg shadow-primary/25">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatar-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
        document.getElementById('file-chosen').textContent = event.target.files[0].name;
    }
</script>
@endsection
