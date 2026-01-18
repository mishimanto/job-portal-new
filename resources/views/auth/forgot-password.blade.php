@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- LEFT : FORGOT PASSWORD FORM -->
        <div class="flex items-center justify-center px-6 lg:px-16 bg-white">
            <div class="w-full max-w-md">
                <h2 class="text-3xl text-center font-semibold text-gray-900 mb-2">
                    Reset Password
                </h2>
                
                <!-- <p class="text-gray-500 text-center mb-8">
                    Enter your email and we'll send you a password reset link
                </p> -->

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-green-700 text-sm">{{ session('status') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <div class="relative">
                            <input type="email" name="email" required autofocus
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none @error('email') border-red-500 @enderror"
                                placeholder="Enter your email"
                                value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <div class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full bg-blue-800 hover:bg-blue-900 text-white py-3 rounded-lg font-medium transition flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Send Reset Link
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <a href="{{ route('login') }}"
                            class="text-sm text-blue-700 hover:underline">
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- RIGHT : MARKETING PANEL -->
        <div class="hidden lg:flex relative flex-col justify-between px-16 py-20 text-white">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1600&q=80"
                    alt="Job Portal Career Background"
                    class="w-full h-full object-cover">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-100/70 to-blue-200/50 backdrop-blur-sm"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10">
                <h2 class="text-4xl text-slate-900 font-semibold leading-tight mb-6">
                    Secure Your Account,<br>
                    Continue Your Journey
                </h2>

                <p class="text-lg text-gray-100 max-w-md">
                    We'll help you regain access to your account quickly and securely.
                    Your career growth is important to us.
                </p>

                <!-- Security Tips -->
                <div class="mt-10 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <i class="fas fa-shield-alt text-blue-300"></i>
                        </div>
                        <div>
                            <p class="font-medium text-blue-100">Secure Password Reset</p>
                            <p class="text-sm text-blue-200">Encrypted link sent directly to your email</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <i class="fas fa-clock text-blue-300"></i>
                        </div>
                        <div>
                            <p class="font-medium text-blue-100">Quick Recovery</p>
                            <p class="text-sm text-blue-200">Reset link expires in 60 minutes for security</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Logos -->
            <div class="relative z-10 opacity-90">
                <p class="text-sm mb-4 uppercase tracking-wide">
                    Trusted by 1000+ Job Seekers
                </p>
                <div class="flex flex-wrap gap-6 text-blue-200 text-sm font-medium">
                    <span>Google</span>
                    <span>Microsoft</span>
                    <span>Amazon</span>
                    <span>Netflix</span>
                    <span>Shopify</span>
                </div>
            </div>
        </div>
@endsection