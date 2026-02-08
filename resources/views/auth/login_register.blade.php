@extends('layouts.app')

@section('title', 'Login or Register - Travaiq')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white to-indigo-50 py-8 px-2">
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden">
        <!-- Left: Login/Register Card -->
        <div class="w-full md:w-1/2 flex flex-col justify-center p-8 md:p-16">
          
           
            <!-- Tabs -->
            <div class="flex justify-center mb-8">
                <button id="tab-login" class="px-8 py-3 text-lg font-semibold rounded-l-lg focus:outline-none transition-all duration-200 bg-primary text-white shadow hover:scale-105 hover:bg-primary-dark focus:ring-2 focus:ring-primary" type="button">Login</button>
                <button id="tab-register" class="px-8 py-3 text-lg font-semibold rounded-r-lg focus:outline-none transition-all duration-200 bg-gray-100 text-primary shadow hover:scale-105 hover:bg-primary-light focus:ring-2 focus:ring-primary" type="button">Register</button>
            </div>
            <!-- Alerts -->
            @if(session('error'))
                <div class="mb-4 text-red-600 text-center font-semibold">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="mb-4 text-green-600 text-center font-semibold">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 text-red-500 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Login Form -->
            <form id="form-login" action="{{ route('loginPost') }}" method="POST" class="space-y-6">
                @csrf
                <h2 class="text-3xl font-bold text-gray-900 mb-2 flex items-center justify-center gap-2">Hi <span class="text-3xl">👋</span></h2>
                <p class="text-gray-500 text-center mb-8 text-lg">Welcome back! Please login to your account.</p>
                <div class="relative">
                    <label for="login-email" class="block text-base font-medium text-gray-700">Email address</label>
                    <input id="login-email" name="email" type="email" autocomplete="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary text-lg px-4 py-3" placeholder="you@email.com">
                </div>
                <div class="relative">
                    <label for="login-password" class="block text-base font-medium text-gray-700">Password <a href="{{ route('forgetPassword') }}" class="float-right text-xs text-primary hover:underline">Forgot?</a></label>
                    <div class="relative">
                        <input id="login-password" name="password" type="password" autocomplete="current-password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary text-lg px-4 py-3 pr-12" placeholder="Your password">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle" data-target="login-password">
                            <svg class="h-5 w-5 text-gray-400 password-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg class="h-5 w-5 text-gray-400 password-eye-slash hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="inline-block w-full px-20 py-3 rounded-lg bg-gradient-to-r from-primary to-primary-light text-white font-medium transition submit-btn">Continue</button>
               
                <div class="flex items-center my-6">
                    
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="mx-2 text-gray-400 text-base">OR</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>
               <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center py-3 rounded-lg border border-gray-200 bg-white text-gray-700 font-medium shadow hover:bg-gray-50 transition text-lg">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="h-6 w-6 mr-2"> Sign in with Google
                </a>
            </form>
            <!-- Register Form -->
            <form id="form-register" action="{{ route('registerPost') }}" method="POST" class="space-y-6 hidden">
                @csrf
                <h2 class="text-3xl font-bold text-gray-900 mb-2 flex items-center justify-center gap-2">Hi <span class="text-3xl">👋</span></h2>
                <p class="text-gray-500 text-center mb-8 text-lg">Create your account to join the adventure!</p>
                <div class="relative">
                    <label for="register-name" class="block text-base font-medium text-gray-700">Full Name</label>
                    <input id="register-name" name="name" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary text-lg px-4 py-3" placeholder="Your name" value="{{ old('name') }}">
                </div>
                <div class="relative">
                    <label for="register-email" class="block text-base font-medium text-gray-700">Email address</label>
                    <input id="register-email" name="email" type="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary text-lg px-4 py-3" placeholder="you@email.com" value="{{ old('email') }}">
                </div>
                <div class="relative">
                    <label for="register-password" class="block text-base font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input id="register-password" name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary text-lg px-4 py-3 pr-12" placeholder="Create a password">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center password-toggle" data-target="register-password">
                            <svg class="h-5 w-5 text-gray-400 password-eye" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg class="h-5 w-5 text-gray-400 password-eye-slash hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="inline-block w-full px-20 py-3 rounded-lg bg-gradient-to-r from-primary to-primary-light text-white font-medium transition submit-btn">Continue</button>

                <div class="flex items-center my-6">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="mx-2 text-gray-400 text-base">OR</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>
                <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center py-3 rounded-lg border border-gray-200 bg-white text-gray-700 font-medium shadow hover:bg-gray-50 transition text-lg">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="h-6 w-6 mr-2"> Sign up with Google
                </a>
            </form>
        </div>
        <!-- Right: Illustration -->
        <div class="hidden md:flex w-1/2 items-center justify-center relative">
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Travel Adventure" class="w-full h-full object-cover object-center">
        </div>
    </div>
</div>
<script>
    // Tab switching logic
    document.addEventListener('DOMContentLoaded', function () {
        const tabLogin = document.getElementById('tab-login');
        const tabRegister = document.getElementById('tab-register');
        const formLogin = document.getElementById('form-login');
        const formRegister = document.getElementById('form-register');

        // Handle form submissions and disable buttons
        const forms = [formLogin, formRegister];
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('.submit-btn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Processing...';
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            });
        });

        // Handle password visibility toggle
        const passwordToggles = document.querySelectorAll('.password-toggle');
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const eyeIcon = this.querySelector('.password-eye');
                const eyeSlashIcon = this.querySelector('.password-eye-slash');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                }
            });
        });

        tabLogin.addEventListener('click', function () {
            tabLogin.classList.add('bg-primary', 'text-white');
            tabLogin.classList.remove('bg-gray-100', 'text-primary');
            tabRegister.classList.remove('bg-primary', 'text-white');
            tabRegister.classList.add('bg-gray-100', 'text-primary');
            formLogin.classList.remove('hidden');
            formRegister.classList.add('hidden');
        });
        tabRegister.addEventListener('click', function () {
            tabRegister.classList.add('bg-primary', 'text-white');
            tabRegister.classList.remove('bg-gray-100', 'text-primary');
            tabLogin.classList.remove('bg-primary', 'text-white');
            tabLogin.classList.add('bg-gray-100', 'text-primary');
            formRegister.classList.remove('hidden');
            formLogin.classList.add('hidden');
        });
    });
</script>
@endsection
