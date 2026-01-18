<!-- resources/views/auth/verify-email.blade.php -->
@extends('layouts.guest')

@section('title', 'Verify Email - Job Portal')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Verify Your Email
            </h2>
            
            <div class="mt-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-envelope text-blue-500 mt-0.5"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-blue-700">
                            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                        </p>
                    </div>
                </div>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mt-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 mt-0.5"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-700">
                                A new verification link has been sent to the email address you provided during registration.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-6 space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="w-full bg-blue-800 hover:bg-blue-900 text-white py-3 rounded-lg font-medium transition">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection