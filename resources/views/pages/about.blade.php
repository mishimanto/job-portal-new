@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">About JobPortal</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            We are dedicated to connecting talented professionals with great career opportunities.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
            <p class="text-gray-600 mb-4">
                To create a seamless and efficient platform that bridges the gap between employers 
                and job seekers, making the hiring process faster, simpler, and more effective for everyone involved.
            </p>
            <p class="text-gray-600">
                We believe that finding the right job or the right candidate shouldn't be a complicated process. 
                Our platform is designed with user experience in mind, ensuring that both employers and job seekers 
                can achieve their goals with minimal friction.
            </p>
        </div>
        <div class="bg-indigo-50 p-8 rounded-2xl">
            <div class="text-center">
                <div class="text-6xl text-indigo-600 mb-4">🎯</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                <p class="text-gray-600">
                    To become the leading job portal that transforms how people find work and how companies find talent.
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8 mb-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Our Values</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-3xl">🤝</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Integrity</h3>
                <p class="text-gray-600">We maintain transparency and honesty in all our operations.</p>
            </div>
            <div class="text-center">
                <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-3xl">💡</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Innovation</h3>
                <p class="text-gray-600">Continuously improving our platform with cutting-edge technology.</p>
            </div>
            <div class="text-center">
                <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-3xl">❤️</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">User Focus</h3>
                <p class="text-gray-600">Everything we do is centered around our users' needs and success.</p>
            </div>
        </div>
    </div>

    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Ready to Start Your Journey?</h2>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
            Join thousands of professionals and companies who have found success through JobPortal.
        </p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700">
                Join Now
            </a>
            <a href="{{ route('jobs.index') }}" class="bg-white text-indigo-600 border border-indigo-600 px-8 py-3 rounded-lg font-bold hover:bg-indigo-50">
                Browse Jobs
            </a>
        </div>
    </div>
</div>
@endsection