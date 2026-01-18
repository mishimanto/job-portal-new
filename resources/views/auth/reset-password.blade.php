@extends('layouts.guest')

@section('title', 'Reset password')

@section('content')
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- LEFT : RESET PASSWORD FORM -->
        <div class="flex items-center justify-center px-6 lg:px-16 bg-white">
            <div class="w-full max-w-md">
                <h2 class="text-3xl text-center font-semibold text-gray-900 mb-2">
                    Reset Password
                </h2>
                
                <!-- <p class="text-gray-500 text-center mb-8">
                    Create a new password for your account
                </p> -->

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
                            </div>
                            <div class="ml-3">
                                <ul class="list-disc list-inside text-red-700 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5" id="resetPasswordForm">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <div class="relative">
                            <input type="email" name="email" required autofocus
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none @error('email') border-red-500 @enderror"
                                placeholder="Email address"
                                value="{{ old('email', $request->email) }}">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="relative">
                            <input type="password" name="password" required id="password"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none @error('password') border-red-500 @enderror"
                                placeholder="New Password">
                            <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-3 text-gray-400">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        
                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="flex space-x-1">
                                <div id="strength1" class="password-strength flex-1 bg-gray-200"></div>
                                <div id="strength2" class="password-strength flex-1 bg-gray-200"></div>
                                <div id="strength3" class="password-strength flex-1 bg-gray-200"></div>
                                <div id="strength4" class="password-strength flex-1 bg-gray-200"></div>
                            </div>
                            <p id="strengthText" class="text-xs text-gray-500 mt-1"></p>
                        </div>
                        
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <div class="relative">
                            <input type="password" name="password_confirmation" required id="password_confirmation"
                                class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none @error('password_confirmation') border-red-500 @enderror"
                                placeholder="Confirm New Password">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-3 text-gray-400">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                        <p class="text-sm font-medium text-blue-800 mb-2">Password Recommandations:</p>
                        <ul class="text-xs text-blue-600 space-y-1">
                            <li id="reqLength" class="flex items-center"><i class="fas fa-circle text-xs mr-2"></i> At least 8 characters</li>
                            <li id="reqUppercase" class="flex items-center"><i class="fas fa-circle text-xs mr-2"></i> At least one uppercase letter</li>
                            <li id="reqLowercase" class="flex items-center"><i class="fas fa-circle text-xs mr-2"></i> At least one lowercase letter</li>
                            <li id="reqNumber" class="flex items-center"><i class="fas fa-circle text-xs mr-2"></i> At least one number</li>
                        </ul>
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full bg-blue-800 hover:bg-blue-900 text-white py-3 rounded-lg font-medium transition">
                        Reset Password
                    </button>

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
                <h2 class="text-4xl font-semibold leading-tight mb-6">
                    Secure Your Future,<br>
                    With Strong Protection
                </h2>

                <p class="text-lg text-indigo-100 max-w-md">
                    A strong password protects your personal data and career opportunities.
                    Create a unique password to keep your account safe.
                </p>

                <!-- Security Tips -->
                <div class="mt-10 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <i class="fas fa-lock text-blue-300"></i>
                        </div>
                        <div>
                            <p class="font-medium text-blue-100">Strong Password</p>
                            <p class="text-sm text-blue-200">Use a mix of letters, numbers, and symbols</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <i class="fas fa-sync-alt text-blue-300"></i>
                        </div>
                        <div>
                            <p class="font-medium text-blue-100">Regular Updates</p>
                            <p class="text-sm text-blue-200">Update your password periodically</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <i class="fas fa-user-shield text-blue-300"></i>
                        </div>
                        <div>
                            <p class="font-medium text-blue-100">Account Security</p>
                            <p class="text-sm text-blue-200">Your career data is protected with encryption</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Logos -->
            <div class="relative z-10 opacity-90">
                <p class="text-sm mb-4 uppercase tracking-wide">
                    Trusted Security Standards
                </p>
                <div class="flex flex-wrap gap-6 text-blue-200 text-sm font-medium">
                    <span>SSL Encryption</span>
                    <span>GDPR Compliant</span>
                    <span>ISO 27001</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
    </style>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength(password) {
            let strength = 0;
            const requirements = {
                length: false,
                uppercase: false,
                lowercase: false,
                number: false
            };
            
            // Length check
            if (password.length >= 8) {
                strength++;
                requirements.length = true;
            }
            
            // Uppercase check
            if (/[A-Z]/.test(password)) {
                strength++;
                requirements.uppercase = true;
            }
            
            // Lowercase check
            if (/[a-z]/.test(password)) {
                strength++;
                requirements.lowercase = true;
            }
            
            // Number check
            if (/[0-9]/.test(password)) {
                strength++;
                requirements.number = true;
            }
            
            // Special character check (bonus)
            if (/[^A-Za-z0-9]/.test(password)) {
                strength = Math.min(strength + 0.5, 4);
            }
            
            return { strength: Math.min(strength, 4), requirements };
        }

        function updatePasswordStrength() {
            const password = document.getElementById('password').value;
            const { strength, requirements } = checkPasswordStrength(password);
            
            // Update strength bars
            const bars = ['strength1', 'strength2', 'strength3', 'strength4'];
            const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
            const texts = ['Very Weak', 'Weak', 'Medium', 'Strong', 'Very Strong'];
            
            bars.forEach((barId, index) => {
                const bar = document.getElementById(barId);
                bar.className = `password-strength flex-1 bg-gray-200`;
                
                if (index < Math.floor(strength)) {
                    bar.classList.add(colors[Math.floor(strength) - 1]);
                } else if (index === Math.floor(strength) && strength % 1 !== 0) {
                    bar.classList.add(colors[Math.floor(strength)]);
                    bar.style.opacity = '0.5';
                }
            });
            
            // Update strength text
            document.getElementById('strengthText').textContent = `Strength: ${texts[Math.floor(strength)]}`;
            
            // Update requirement icons
            const reqIds = ['reqLength', 'reqUppercase', 'reqLowercase', 'reqNumber'];
            const reqKeys = ['length', 'uppercase', 'lowercase', 'number'];
            
            reqIds.forEach((reqId, index) => {
                const reqElement = document.getElementById(reqId);
                const icon = reqElement.querySelector('i');
                
                if (requirements[reqKeys[index]]) {
                    icon.className = 'fas fa-check text-green-500 text-xs mr-2';
                    reqElement.classList.add('text-green-600');
                    reqElement.classList.remove('text-blue-600');
                } else {
                    icon.className = 'fas fa-circle text-xs mr-2';
                    reqElement.classList.remove('text-green-600');
                    reqElement.classList.add('text-blue-600');
                }
            });
        }

        // Add event listeners
        document.getElementById('password').addEventListener('input', updatePasswordStrength);
        
        // Initialize
        updatePasswordStrength();
    </script>
@endsection