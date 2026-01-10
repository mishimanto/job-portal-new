@extends('layouts.app')

@section('title', 'Home - ' . config('app.name', 'JobPortal'))

@section('content')
    <!-- Hero Section Start -->
    <div class="relative">
        <!-- Hero Background -->
        <div class="relative h-screen bg-cover bg-center hero-bg">
            <!-- Overlay -->
            <div class="hero-overlay"></div>
            
            <!-- Hero Content -->
            <div class="relative h-full flex items-center hero-section">
                <div class="container mx-auto px-4">
                    <div class="max-w-3xl mx-auto text-center">
                        <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 animate-fade-in-up">
                            Find Your Dream Career Opportunity
                        </h1>
                        <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto animate-fade-in-up animation-delay-200">
                            Connect with top employers and discover thousands of job opportunities that match your skills
                        </p>
                        
                        <!-- Search Box -->
                        <div class="mt-10 bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-2 md:p-3 animate-fade-in-up animation-delay-400">
                            <form action="{{ route('jobs.index') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                                <div class="flex-1">
                                    <div class="relative">
                                        <i class="fas fa-search absolute left-6 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" 
                                               name="search"
                                               placeholder="Job Title, Keywords, or Company" 
                                               class="w-full pl-14 pr-6 py-5 rounded-xl border-0 focus:ring-2 focus:ring-indigo-500 text-lg bg-white/50 backdrop-blur-sm">
                                    </div>
                                </div>
                                <div class="md:w-64">
                                    <div class="relative">
                                        <i class="fas fa-map-marker-alt absolute left-6 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" 
                                               name="location"
                                               placeholder="City, State, or Remote" 
                                               class="w-full pl-14 pr-6 py-5 rounded-xl border-0 focus:ring-2 focus:ring-indigo-500 text-lg bg-white/50 backdrop-blur-sm">
                                    </div>
                                </div>
                                <button type="submit" 
                                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-10 py-5 rounded-xl font-bold text-lg transition-all duration-300 whitespace-nowrap shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <i class="fas fa-search mr-2"></i> Search Jobs
                                </button>
                            </form>
                            <div class="mt-4 px-4 flex flex-wrap gap-4 text-sm text-gray-600">
                                <span class="font-medium">Popular Searches:</span>
                                <a href="{{ route('jobs.index', ['job_type' => 'remote']) }}" class="hover:text-indigo-600">Remote Jobs</a>
                                <a href="{{ route('jobs.index', ['job_type' => 'full-time']) }}" class="hover:text-indigo-600">Full Time</a>
                                <a href="{{ route('jobs.index', ['experience_level' => 'senior']) }}" class="hover:text-indigo-600">Senior Level</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Scroll Indicator -->
            <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
                <a href="#categories" class="text-white">
                    <i class="fas fa-chevron-down text-2xl"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Hero Section End -->

    <!-- Stats Section Start -->
    <!-- <div class="relative bg-blue-50">
        <div class="mx-auto">

            <div class="grid grid-cols-2 md:grid-cols-4">

                    @php
                        $totalJobs = \App\Models\Job::active()->count();
                        $totalCompanies = \App\Models\Company::where('is_active', true)->count();
                        $totalApplications = \App\Models\JobApplication::count();
                        $jobSeekers = \App\Models\User::where('role', 'job_seeker')->where('is_active', true)->count();
                    @endphp

                
                <div class="group bg-white p-8 text-center 
                            transition-all duration-300 
                            hover:-translate-y-2 hover:shadow-xl hover:border-blue-300">
                    
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-3 
                                transition group-hover:scale-105">
                        {{ $totalJobs }}
                    </div>
                    <div class="text-gray-700 font-medium tracking-wide">
                        Available Jobs
                    </div>
                </div>

                <div class="group bg-white p-8 text-center 
                            transition-all duration-300 
                            hover:-translate-y-2 hover:shadow-xl hover:border-blue-300">

                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-3 
                                transition group-hover:scale-105">
                        {{ $totalCompanies }}+
                    </div>
                    <div class="text-gray-700 font-medium tracking-wide">
                        Companies
                    </div>
                </div>

                <div class="group bg-white p-8 text-center 
                            transition-all duration-300 
                            hover:-translate-y-2 hover:shadow-xl hover:border-blue-300">

                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-3 
                                transition group-hover:scale-105">
                        {{ $totalApplications }}+
                    </div>
                    <div class="text-gray-700 font-medium tracking-wide">
                        Applications
                    </div>
                </div>

                <div class="group bg-white p-8 text-center 
                            transition-all duration-300 
                            hover:-translate-y-2 hover:shadow-xl hover:border-blue-300">

                    <div class="text-4xl md:text-5xl font-bold text-blue-600 mb-3 
                                transition group-hover:scale-105">
                        {{ $jobSeekers }}+
                    </div>
                    <div class="text-gray-700 font-medium tracking-wide">
                        Job Seekers
                    </div>
                </div>

            </div>
        </div>
    </div> -->

    <!-- Stats Section End -->

    <!-- Categories Section Start -->
    <div id="categories" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <!-- Section Title -->
            <div class="flex flex-col md:flex-row items-center justify-between mb-16">
                <h2 class="text-3xl md:text-3xl font-bold text-gray-900 mb-4 md:mb-0">
                    Categories
                </h2>

                <a href="{{ route('jobs.index') }}" 
                class="text-indigo-600 font-bold text-lg hover:underline transition-all duration-300">
                    View All Categories
                </a>
            </div>


            <!-- Categories Grid -->
            @php
                $categories = \App\Models\Category::where('is_active', true)
                    ->withCount(['jobs' => function($query) {
                        $query->active();
                    }])
                    ->orderBy('order')
                    ->take(8)
                    ->get();
            @endphp
            
            @if($categories->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($categories as $category)
                        <a href="{{ route('jobs.index', ['category' => $category->id]) }}" 
                           class="group bg-gray-50 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-white rounded-2xl p-8 text-center transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 border border-gray-200 hover:border-indigo-200">
                            <!-- <div class="w-20 h-20 mx-auto mb-6 rounded-xl bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center group-hover:from-indigo-200 group-hover:to-purple-200 transition-all duration-300">
                                @if($category->icon)
                                    <div class="text-3xl">{!! $category->icon !!}</div>
                                @else
                                    <i class="fas fa-folder text-3xl text-indigo-600"></i>
                                @endif
                            </div> -->
                            <h3 class="text-xl font-bold text-blue-500 mb-2 group-hover:text-indigo-700">{{ $category->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $category->jobs_count }} open jobs</p>
                            <!-- @if($category->description)
                                <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ Str::limit($category->description, 60) }}</p>
                            @endif -->
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-folder-open text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Categories Available</h3>
                    <!-- <p class="text-gray-600">Job categories will be listed here soon.</p> -->
                </div>
            @endif
        </div>
    </div>
    <!-- Categories Section End -->

    <!-- Featured Jobs Section Start -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row items-center justify-between mb-10">
                <h2 class="text-3xl md:text-3xl font-bold text-gray-900 mb-3">Latest Job Opportunities</h2>
                <a href="{{ route('jobs.index') }}" 
                   class="text-indigo-600 font-bold text-lg hover:underline transition-all duration-300">
                    View All Jobs
                </a>
            </div>

            <!-- Jobs Grid -->
            @php
                $featuredJobs = \App\Models\Job::active()
                    ->with(['company', 'user'])
                    ->orderBy('created_at', 'desc')
                    ->take(6)
                    ->get();
            @endphp
            
            @if($featuredJobs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredJobs as $job)
                <div class="group relative bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-indigo-200 hover:-translate-y-1">
                    <!-- Job Type Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold 
                            @if($job->job_type == 'full-time') bg-emerald-50 text-emerald-700 
                            @elseif($job->job_type == 'part-time') bg-blue-50 text-blue-700
                            @elseif($job->job_type == 'contract') bg-amber-50 text-amber-700
                            @elseif($job->job_type == 'remote') bg-purple-50 text-purple-700
                            @else bg-gray-50 text-gray-700 @endif">
                            {{ strtoupper(str_replace('-', ' ', $job->job_type)) }}
                        </span>
                    </div>

                    <div class="p-6">
                        <!-- Company & Title -->
                        <div class="flex items-start gap-4 mb-5">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-indigo-50 to-purple-100 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                    @if ($job->company_logo)
                                            <img src="{{ asset('storage/' . $job->company_logo) }}"
                                                alt="{{ $job->company_name }}"
                                                class="w-14 h-14 rounded-sm object-cover border border-gray-200">
                                        @else
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-gray-900 truncate group-hover:text-indigo-700 transition-colors">
                                    <a href="{{ route('jobs.show', $job) }}" class="hover:underline">{{ $job->title }}</a>
                                </h3>
                                <p class="text-sm font-medium text-gray-700 mt-1">{{ $job->company ? $job->company->name : ($job->company_name ?? '') }}</p>
                            </div>
                        </div>

                        <!-- Job Details - Compact Layout -->
                        <div class="space-y-3 mb-6">
                            <!-- Location & Experience in one line -->
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $job->location }}</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ ucfirst($job->experience_level) }}</span>
                                </div>
                            </div>

                            <!-- Salary -->
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold text-gray-900">
                                    @if($job->is_negotiable)
                                        <span class="text-amber-600">Negotiable</span>
                                    @elseif($job->salary_min && $job->salary_max)
                                        @php
                                            $currencySymbol = '$';
                                            if($job->salary_currency == 'EUR') $currencySymbol = '€';
                                            elseif($job->salary_currency == 'GBP') $currencySymbol = '£';
                                            elseif($job->salary_currency == 'BDT') $currencySymbol = '৳';
                                            elseif($job->salary_currency == 'INR') $currencySymbol = '₹';
                                        @endphp
                                        {{ $currencySymbol }}{{ number_format($job->salary_min) }}-{{ $currencySymbol }}{{ number_format($job->salary_max) }}
                                    @elseif($job->salary)
                                        {{ $job->salary }}
                                    @else
                                        <span class="text-gray-500">Not specified</span>
                                    @endif
                                </span>
                            </div>

                            <!-- Skills (if available) -->
                            @php
                                $skills = [];
                                if($job->skills_required) {
                                    if(is_array($job->skills_required)) {
                                        $skills = array_slice($job->skills_required, 0, 3);
                                    } elseif(is_string($job->skills_required)) {
                                        $decoded = json_decode($job->skills_required, true);
                                        if(json_last_error() === JSON_ERROR_NONE) {
                                            $skills = array_slice($decoded, 0, 3);
                                        }
                                    }
                                }
                            @endphp
                            
                            @if(!empty($skills))
                            <div class="flex flex-wrap gap-1.5 pt-2">
                                @foreach($skills as $skill)
                                <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-md">
                                    {{ trim($skill) }}
                                </span>
                                @endforeach
                                @if(count($skills) > 3)
                                <span class="inline-block px-2 py-1 bg-gray-100 text-gray-500 text-xs rounded-md">
                                    +{{ count($skills) - 3 }} more
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>

                        <!-- Posted Time & Apply Button -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $job->created_at->diffForHumans() }}
                            </div>
                            <a href="{{ route('jobs.show', $job) }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-all duration-300 transform group-hover:scale-105 hover:shadow-md">
                                Apply Now
                                <svg class="w-3.5 h-3.5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- View All Button -->
            <!-- <div class="text-center mt-10">
                <a href="{{ route('jobs.index') }}" 
                class="inline-flex items-center px-6 py-3 border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white font-semibold rounded-lg transition-all duration-300 hover:shadow-lg">
                    View All Jobs
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div> -->
            @else
            <!-- Empty State -->
            <div class="max-w-md mx-auto text-center py-12">
                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-r from-gray-100 to-gray-200 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">No Jobs Available</h3>
                <p class="text-gray-600">New opportunities coming soon!</p>
            </div>
            @endif
        </div>
    </section>
    <!-- Featured Jobs Section End -->

    <!-- How It Works Section Start -->
    <section class="relative py-32 bg-[#1f2f87] text-white overflow-hidden how-it-works-bg">
        {{-- Overlay (optional for better contrast) --}}
        <div class="absolute inset-0"></div>

        <div class="relative max-w-7xl mx-auto px-6">
            {{-- Section Title --}}
            <div class="text-center mb-16">
                <span class="text-sm font-semibold tracking-widest text-pink-400 uppercase">
                    Apply Process
                </span>
                <h2 class="mt-3 text-4xl font-bold">
                    How it works
                </h2>
            </div>

            {{-- Process Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                
                {{-- Card 1 --}}
                <div class="bg-white/10 backdrop-blur rounded-lg p-10 text-center hover:bg-white/15 transition">
                    <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full border border-white/30">
                        {{-- Icon --}}
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M21 21l-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z"/>
                        </svg>
                    </div>
                    <h5 class="text-xl font-semibold mb-3">1. Search a job</h5>
                    <!-- <p class="text-sm text-white/80 leading-relaxed">
                        Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt.
                    </p> -->
                </div>

                {{-- Card 2 --}}
                <div class="bg-white/10 backdrop-blur rounded-lg p-10 text-center hover:bg-white/15 transition">
                    <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full border border-white/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <path d="M20 8v6M23 11h-6"/>
                        </svg>
                    </div>
                    <h5 class="text-xl font-semibold mb-3">2. Apply for job</h5>
                    <!-- <p class="text-sm text-white/80 leading-relaxed">
                        Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt.
                    </p> -->
                </div>

                {{-- Card 3 --}}
                <div class="bg-white/10 backdrop-blur rounded-lg p-10 text-center hover:bg-white/15 transition">
                    <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full border border-white/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4"/>
                            <path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
                        </svg>
                    </div>
                    <h5 class="text-xl font-semibold mb-3">3. Get your job</h5>
                    <!-- <p class="text-sm text-white/80 leading-relaxed">
                        Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt.
                    </p> -->
                </div>

            </div>
        </div>
    </section>

    <!-- How It Works Section End -->

    <!-- Testimonials Section Start -->
    <div class="py-20 bg-gradient-to-r from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <!-- Section Title -->
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-indigo-100 text-indigo-600 rounded-full font-semibold uppercase tracking-wider text-sm mb-4">Testimonials</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Success Stories</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Hear from professionals who found their dream jobs through our platform</p>
            </div>

            <!-- Testimonial Slider -->
            @php
                // In a real application, you'd have a testimonials table or user testimonials
                // For now, using sample testimonials from successful job seekers
                $testimonials = [
                    [
                        'name' => 'Sarah Johnson',
                        'position' => 'Senior UX Designer',
                        'company' => 'TechVision Inc.',
                        'content' => "Found my perfect remote role within 2 weeks! The platform's filters helped me target exactly what I was looking for. The application process was seamless.",
                        'avatar' => 'testimonial-founder.png'
                    ],
                    [
                        'name' => 'Michael Chen',
                        'position' => 'Full Stack Developer',
                        'company' => 'InnovateSoft',
                        'content' => "After months of searching, I landed my dream job through this portal. The quality of job listings and the responsiveness of employers exceeded my expectations.",
                        'avatar' => 'testimonial-founder.png'
                    ],
                    [
                        'name' => 'Emma Wilson',
                        'position' => 'Marketing Director',
                        'company' => 'GrowthMarketing Pro',
                        'content' => "The resume builder and profile features helped me stand out. I received interview requests from 5 companies within the first week of joining.",
                        'avatar' => 'testimonial-founder.png'
                    ]
                ];
            @endphp

            <div class="testimonial-slider swiper-container max-w-5xl mx-auto">
                <div class="swiper-wrapper">
                    @foreach($testimonials as $testimonial)
                        <div class="swiper-slide">
                            <div class="bg-white rounded-3xl p-10 shadow-xl hover:shadow-2xl transition-all duration-300">
                                <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
                                    <div class="text-center lg:text-left">
                                        <div class="w-28 h-28 mx-auto lg:mx-0 mb-6 rounded-full overflow-hidden border-4 border-indigo-100 shadow-lg">
                                            <img src="{{ asset('assets/img/testmonial/' . $testimonial['avatar']) }}" 
                                                 alt="{{ $testimonial['name'] }}" 
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $testimonial['name'] }}</h3>
                                        <p class="text-indigo-600 font-medium mb-1">{{ $testimonial['position'] }}</p>
                                        <p class="text-gray-600 text-sm">{{ $testimonial['company'] }}</p>
                                    </div>
                                    <div class="flex-1">
                                        <div class="mb-6">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-yellow-400 text-xl"></i>
                                            @endfor
                                        </div>
                                        <p class="text-gray-700 text-lg italic leading-relaxed">
                                            <i class="fas fa-quote-left text-indigo-200 text-2xl mr-4 align-top"></i>
                                            {{ $testimonial['content'] }}
                                            <i class="fas fa-quote-right text-indigo-200 text-2xl ml-4 align-top"></i>
                                        </p>
                                        <div class="mt-8 pt-6 border-t border-gray-100">
                                            <div class="flex items-center text-gray-500">
                                                <i class="far fa-clock mr-2"></i>
                                                <span class="text-sm">Hired 3 months ago</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Navigation -->
                <div class="flex justify-center items-center mt-12 space-x-4">
                    <button class="testimonial-prev w-12 h-12 rounded-full bg-white shadow-md hover:shadow-lg transition-all duration-300 hover:bg-gray-50 flex items-center justify-center">
                        <i class="fas fa-chevron-left text-gray-700"></i>
                    </button>
                    <div class="swiper-pagination"></div>
                    <button class="testimonial-next w-12 h-12 rounded-full bg-white shadow-md hover:shadow-lg transition-all duration-300 hover:bg-gray-50 flex items-center justify-center">
                        <i class="fas fa-chevron-right text-gray-700"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonials Section End -->

    <section class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Left Content --}}
            <div>
                <span class="text-sm font-semibold text-blue-500 uppercase">
                    What we are doing
                </span>

                <h2 class="mt-4 text-4xl font-bold text-gray-900 leading-tight">
                    24k Talented people <br> are getting Jobs
                </h2>

                <p class="mt-6 text-gray-600 leading-relaxed">
                    Mollit anim laborum duis au dolor in voluptate velit ess cillum dolore eu lore
                    dsu quality mollit anim laborumuis au dolor in voluptate velit cillum.
                </p>

                <p class="mt-4 text-gray-600 leading-relaxed">
                    Mollit anim laborum. Duis aute irufg dhjkolohr in re voluptate velit ess cillum
                    lore eu quife nrulla parihatur. Excghcepteur signjnt occa cupidatat non inulpadeserunt.
                </p>

                <a href="{{ url('/jobs/create') }}"
                    class="inline-block mt-8 px-8 py-3 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 transition">
                    Post a Job
                </a>

            </div>

            {{-- Right Image --}}
            <div class="relative">
                <img 
                    src="{{ asset('assets/img/service/support-img.jpg') }}"
                    class="w-full rounded-lg object-cover"
                    alt="Support"
                >

                {{-- Since Badge --}}
                <div class="absolute bottom-0 left-0 bg-indigo-900 text-white px-6 py-5 text-center">
                    <p class="text-xs uppercase tracking-wide">Since</p>
                    <span class="text-3xl font-bold">2014</span>
                </div>
            </div>

        </div>
    </section>

    <!-- Call to Action Start -->
    <div class="relative py-28 overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
            class="w-full h-full object-cover object-center scale-105 animate-zoom-slow">
            
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/70 to-blue-700/70 backdrop-blur-[2px]"></div>
    </div>


        <!-- Animated Elements -->
        <div class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-white/5 to-transparent rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-white/5 to-transparent rounded-full translate-x-1/3 translate-y-1/3"></div>

        <div class="relative container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <!-- Badge -->
                <!-- <div class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-full font-semibold uppercase tracking-wider text-sm mb-6 hover:bg-white/15 transition-all duration-300 group">
                    <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span>Career Accelerator</span>
                </div> -->

                <!-- Heading -->
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    Launch Your
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-cyan-300">Dream Career</span>
                    Today
                </h2>
                
                <!-- Description -->
                <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Join thousands of professionals who found their perfect match. Upload your resume and let AI-powered matching connect you with top employers.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    @auth
                        @if(auth()->user()->isJobSeeker())
                        <a href="{{ route('job-seeker.profile.edit') }}" 
                        class="group relative inline-flex items-center justify-center gap-3 bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-2xl hover:shadow-3xl hover:-translate-y-1 min-w-[220px]">
                            <div class="absolute inset-0 bg-white/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span>Complete Profile</span>
                        </a>
                        @endif
                    @else
                    <a href="{{ route('register') }}" 
                    class="group relative inline-flex items-center justify-center gap-3 bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-2xl hover:shadow-3xl hover:-translate-y-1 min-w-[220px]">
                        <div class="absolute inset-0 bg-white/10 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        <span>Create Free Account</span>
                    </a>
                    @endauth
                    
                    <a href="#" 
                    class="group relative inline-flex items-center justify-center gap-3 bg-transparent border-2 border-white/30 hover:border-white text-white hover:bg-white/10 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 backdrop-blur-sm hover:backdrop-blur-md min-w-[220px]">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 to-white/5 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <span>Upload Resume</span>
                    </a>
                </div>

                <!-- Stats -->
                <!-- <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 pt-10 border-t border-white/20">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white mb-2">10K+</div>
                        <div class="text-sm text-white/70 uppercase tracking-wider">Jobs Posted</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white mb-2">5K+</div>
                        <div class="text-sm text-white/70 uppercase tracking-wider">Companies</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white mb-2">85%</div>
                        <div class="text-sm text-white/70 uppercase tracking-wider">Success Rate</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-white mb-2">24h</div>
                        <div class="text-sm text-white/70 uppercase tracking-wider">Fast Response</div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- Call to Action End -->

    <style>
    @keyframes zoom-slow {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
    .animate-zoom-slow {
        animation: zoom-slow 20s ease-in-out infinite;
    }
    </style>
    <!-- Top Companies Section Start -->
    <div class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <!-- Section Title -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
                <div>
                    <!-- <span class="inline-block px-4 py-2 bg-indigo-100 text-indigo-600 rounded-full font-semibold uppercase tracking-wider text-sm mb-4">Companies</span> -->
                    <h2 class="text-3xl md:text-3xl font-bold text-gray-900 mb-2">Top Hiring Companies</h2>
                    <!-- <p class="text-gray-600 text-lg">Leading employers actively hiring on our platform</p> -->
                </div>
            </div>

            <!-- Companies Grid -->
            @php
                $companies = \App\Models\Company::where('is_active', true)
                    ->withCount(['jobs' => function($query) {
                        $query->active();
                    }])
                    ->orderByDesc('jobs_count')
                    ->take(6)
                    ->get();
            @endphp
            
            @if($companies->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    @foreach($companies as $company)
                        <a href="{{ route('jobs.index', ['company' => $company->id]) }}" 
                           class="group bg-gray-50 hover:bg-white rounded-lg p-6 text-center transition-all duration-300 hover:shadow-xl border border-gray-200 hover:border-indigo-200">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-xl bg-white p-3 flex items-center justify-center group-hover:shadow-md transition-all duration-300">
                                @if($company->logo)
                                    <img src="{{ asset('storage/' . $company->logo) }}" 
                                         alt="{{ $company->name }}" 
                                         class="w-full h-full object-contain">
                                @else
                                    <i class="fas fa-building text-3xl text-gray-400"></i>
                                @endif
                            </div>
                            <h3 class="font-bold text-gray-900 group-hover:text-indigo-700 mb-1">{{ $company->name }}</h3>
                            <!-- <div class="text-sm text-gray-600">{{ $company->jobs_count }} open positions</div>
                            @if($company->industry)
                                <div class="text-xs text-gray-500 mt-2">{{ $company->industry }}</div>
                            @endif -->
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-building text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Companies Listed</h3>
                    <!-- <p class="text-gray-600">Companies will be featured here soon.</p> -->
                </div>
            @endif
        </div>
    </div>
    <!-- Top Companies Section End -->

    <!-- Blog Section Start -->
    <div class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <!-- Section Title -->
            <div class="text-center mb-16">
                <!-- <span class="inline-block px-4 py-2 bg-indigo-100 text-indigo-600 rounded-full font-semibold uppercase tracking-wider text-sm mb-4">Insights</span> -->
                <h2 class="text-4xl md:text-4xl font-bold text-gray-900 mb-6">Career Tips & Insights</h2>
                <!-- <p class="text-gray-600 text-lg max-w-2xl mx-auto">Stay updated with the latest trends and advice for your career growth</p> -->
            </div>

            <!-- Blog Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Blog Post 1 -->
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/img/blog/home-blog1.jpg') }}" 
                             alt="Resume Building Tips" 
                             class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-6 left-6">
                            <div class="bg-white px-4 py-3 rounded-xl text-center shadow-md">
                                <div class="text-xl font-bold text-gray-900">24</div>
                                <div class="text-gray-600 text-xs">Jan</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <span class="bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full text-xs font-medium mr-3">Career Tips</span>
                            <span><i class="far fa-clock mr-1"></i> 5 min read</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-indigo-700 transition-colors">
                            <a href="#">5 Essential Tips for Building a Winning Resume in 2024</a>
                        </h3>
                        <p class="text-gray-600 mb-6">Learn how to create a resume that stands out to recruiters and gets you more interview calls.</p>
                        <a href="#" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-bold">
                            Read More <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Blog Post 2 -->
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/img/blog/home-blog2.jpg') }}" 
                             alt="Interview Preparation" 
                             class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-6 left-6">
                            <div class="bg-white px-4 py-3 rounded-xl text-center shadow-md">
                                <div class="text-xl font-bold text-gray-900">20</div>
                                <div class="text-gray-600 text-xs">Jan</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <span class="bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full text-xs font-medium mr-3">Interviews</span>
                            <span><i class="far fa-clock mr-1"></i> 7 min read</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-indigo-700 transition-colors">
                            <a href="#">Ace Your Next Job Interview: Common Questions & Best Answers</a>
                        </h3>
                        <p class="text-gray-600 mb-6">Prepare for success with our guide to the most common interview questions and expert-approved answers.</p>
                        <a href="#" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-bold">
                            Read More <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Blog Post 3 -->
                <div class="bg-white overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('assets/img/blog/home-blog2.jpg') }}" 
                             alt="Remote Work Guide" 
                             class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-6 left-6">
                            <div class="bg-white px-4 py-3 rounded-xl text-center shadow-md">
                                <div class="text-xl font-bold text-gray-900">18</div>
                                <div class="text-gray-600 text-xs">Jan</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <span class="bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full text-xs font-medium mr-3">Remote Work</span>
                            <span><i class="far fa-clock mr-1"></i> 6 min read</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-indigo-700 transition-colors">
                            <a href="#">The Ultimate Guide to Succeeding in Remote Work Environments</a>
                        </h3>
                        <p class="text-gray-600 mb-6">Master the skills and habits needed to excel in remote work settings and maintain work-life balance.</p>
                        <a href="#" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-bold">
                            Read More <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- View More Button -->
            <div class="mt-12 flex justify-end">
                <a href="#"
                class="text-blue-600 font-semibold text-lg hover:underline underline-offset-8 transition">
                    View All Articles
                </a>
            </div>

        </div>
    </div>
    <!-- Blog Section End -->
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animation-delay-200 {
        animation-delay: 0.2s;
    }

    .animation-delay-400 {
        animation-delay: 0.4s;
    }

    .testimonial-slider .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: #c7d2fe;
        opacity: 1;
    }
    
    .testimonial-slider .swiper-pagination-bullet-active {
        background: #4f46e5;
    }

    .hero-bg {
        background-image: url('{{ asset('assets/img/hero/h1_hero.jpg') }}');
    }

    .cta-bg {
        background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('{{ asset('assets/img/gallery/cv_bg.jpg') }}');
    }

    .how-it-works-bg {
        background-image: url('{{ asset('assets/img/gallery/how-applybg.png') }}');
        background-size: cover;
        background-position: center;
    }

    .hero-bg {
    background-image: url('{{ asset('assets/img/hero/h1_hero.jpg') }}');
    }

    .cta-bg {
    background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('{{ asset('assets/img/gallery/cv_bg.jpg') }}');
    }

    .how-it-works-bg {
    background-image: url('{{ asset('assets/img/gallery/how-applybg.png') }}');
    background-size: cover;
    background-position: center;
    }
    
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Testimonial Slider
        const testimonialSwiper = new Swiper('.testimonial-slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.testimonial-next',
                prevEl: '.testimonial-prev',
            },
            spaceBetween: 30,
            slidesPerView: 1,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if(targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all sections for animation
        document.querySelectorAll('section, .grid > div').forEach(section => {
            observer.observe(section);
        });
    });
</script>
@endpush