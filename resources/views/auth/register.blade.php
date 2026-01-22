<!-- resources/views/auth/register.blade.php -->
@extends('layouts.guest')

@section('title', 'Register - Job Portal')

@section('content')
<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
    <!-- LEFT : FULL IMAGE BACKGROUND -->
    <div class="hidden lg:flex relative items-center justify-center text-white">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Career Growth Background"
                class="w-full h-full object-cover">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-100/70 to-blue-200/50 backdrop-blur-sm"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 px-16">
            <h2 class="text-4xl text-blue-800 font-semibold leading-tight mb-6">
                Start Your Career Journey<br>
                With the Right Opportunity
            </h2>

            <p class="text-lg text-blue-500 max-w-md mb-10">
                Join thousands of job seekers who found their dream jobs.
                Build your profile, apply confidently, and get hired faster.
            </p>

            <!-- Quote -->
            <div class="flex items-center gap-4">
                <img src="https://i.pravatar.cc/80?img=45"
                     class="w-12 h-12 rounded-full border border-white/30">
                <div>
                    <p class="font-medium">Nusrat Jahan</p>
                    <p class="text-sm text-blue-200">
                        Software Engineer
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT : REGISTER FORM -->
    <div class="flex items-center justify-center bg-white py-12 px-6 lg:px-16">
        <div class="w-full max-w-md space-y-8">
            <!-- Header -->
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Sign Up
                </h2>
                
                <!-- <p class="mt-2 text-sm text-gray-600">
                    Create your account to start your career journey
                </p> -->
            </div>

            <!-- FORM -->
            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Full Name -->
                <div>
                    <input id="name" name="name" type="text" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none @error('name') border-red-500 @enderror"
                           placeholder="Full Name"
                           value="{{ old('name') }}">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <input id="email" name="email" type="email" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none @error('email') border-red-500 @enderror"
                           placeholder="Email address"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <input id="phone" name="phone" type="tel"
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none @error('phone') border-red-500 @enderror"
                           placeholder="Phone Number (Optional)"
                           value="{{ old('phone') }}">
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="relative">
                    <input id="password" name="password" type="password" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none @error('password') border-red-500 @enderror"
                           placeholder="Password">
                    <button type="button" onclick="togglePassword('password')"
                            class="absolute right-3 top-3 text-gray-400">
                        <i id="password-eye" class="fas fa-eye"></i>
                    </button>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none"
                           placeholder="Confirm Password">
                    <button type="button" onclick="togglePassword('password_confirmation')"
                            class="absolute right-3 top-3 text-gray-400">
                        <i id="confirm-eye" class="fas fa-eye"></i>
                    </button>
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="terms" class="ml-2 text-sm text-gray-900">
                        I agree to the
                        <a href="#" class="text-blue-600 hover:text-blue-800">Terms</a> &
                        <a href="#" class="text-blue-600 hover:text-blue-800">Privacy Policy</a>
                    </label>
                    @error('terms')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full bg-blue-800 hover:bg-blue-900 text-white py-3 rounded-lg font-medium transition">
                    Create Account
                </button>

                <p class="mt-4 text-center text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800">
                        Sign in here
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const input = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(fieldId === 'password' ? 'password-eye' : 'confirm-eye');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection