@extends('layouts.app')

@section('title', 'Forgot Password - Travaiq')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white to-indigo-50 py-8 px-2">
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden">
        <!-- Left: Forgot Password Card -->
        <div class="w-full md:w-1/2 flex flex-col justify-center p-8 md:p-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-2 flex items-center justify-center gap-2">Forgot your password?</h2>
            <p class="text-gray-500 text-center mb-8 text-lg">Enter your email address and we'll send you a link to reset your password.</p>
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
            <!-- Forgot Password Form -->
            <form id="form-login" action="{{ route('userForgetpassword') }}" method="POST" class="space-y-6">
                @csrf
               
                <div class="relative">
                    <label for="login-email" class="block text-base font-medium text-gray-700">Email address</label>
                    <input id="login-email" name="email" type="email" autocomplete="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary text-lg px-4 py-3" placeholder="you@email.com">
                </div>
                
                <button type="submit" class="inline-block w-full px-20 py-3 rounded-lg bg-gradient-to-r from-primary to-primary-light text-white font-medium transition submit-btn">Send Reset Link</button>
               
                
            </form>
            <div class="mt-8 text-center">
                <a href="{{ route('loginRegister') }}" class="text-primary hover:underline">Back to Login</a>
            </div>
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
