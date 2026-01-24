@extends('layouts.admin')

@section('title', 'Post New Job - Admin Panel')
@section('page-title', 'Post New Job')
@section('page-subtitle', 'Create a new job posting')

@section('breadcrumbs')
<li>
    <div class="flex items-center">
        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
        </svg>
        <a href="{{ route('admin.jobs.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
            Jobs
        </a>
    </div>
</li>
<li>
    <div class="flex items-center">
        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
        </svg>
        <span class="ml-4 text-sm font-medium text-gray-500">
            Post New Job
        </span>
    </div>
</li>
@endsection

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header with Stats -->
    <div class="mb-8">
        <!-- <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-xl mr-4">
                        <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Post New Job</h1>
                        <p class="mt-2 text-lg text-gray-600">Create a new job posting for your platform</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.jobs.index') }}" 
                   class="inline-flex items-center px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Jobs
                </a>
            </div>
        </div> -->
        
        <!-- Progress Steps -->
        <div class="mt-8 max-w-7xl mx-auto">
            <div class="relative flex items-center justify-between">

                <!-- Background Line -->
                <!-- <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gray-200 -translate-y-1/2"></div> -->

                <!-- Step 1 -->
                <div class="relative z-10 flex items-center gap-3 px-2">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                        <span class="text-white font-semibold">1</span>
                    </div>
                    <span class="whitespace-nowrap text-sm font-medium text-blue-600">Basic Info</span>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 flex items-center gap-3 px-2">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                        <span class="text-white font-semibold">2</span>
                    </div>
                    <span class="whitespace-nowrap text-sm font-medium text-blue-600">Details</span>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 flex items-center gap-3  px-2">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                        <span class="text-white font-semibold">3</span>
                    </div>
                    <span class="whitespace-nowrap text-sm font-medium text-blue-600">Salary</span>
                </div>

                <!-- Step 4 -->
                <div class="relative z-10 flex items-center gap-3 px-2">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                        <span class="text-white font-semibold">4</span>
                    </div>
                    <span class="whitespace-nowrap text-sm font-medium text-blue-600">Requirements</span>
                </div>

            </div>
        </div>

    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-8">
        <!-- Form Header -->
        <!-- <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-blue-100 rounded-xl">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-bold text-gray-900">Job Information Form</h2>
                        <p class="text-sm text-gray-600 mt-1">Complete all sections to create your job posting</p>
                    </div>
                </div>
                <div class="px-4 py-2 bg-blue-100 rounded-full">
                    <span class="text-sm font-semibold text-blue-700">Step 1 of 4</span>
                </div>
            </div>
        </div> -->

        <!-- Form Content -->
        <form action="{{ route('admin.jobs.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
            @csrf
            
            <!-- Basic Information -->
            <div class="px-8 py-8">
                <div class="mb-2">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-blue-50 rounded-lg mr-3">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Basic Information</h3>
                        <!-- <span class="ml-2 text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">Required</span> -->
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Grid Row 1 -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Job Title -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <label for="title" class="block text-sm font-semibold text-gray-800">
                                        Job Title
                                    </label>
                                    <span class="ml-1 text-red-500">*</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="title" id="title" 
                                           value="{{ old('title') }}"
                                           placeholder="e.g., Senior Software Engineer"
                                           required
                                           class="pl-10 block w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 group-hover:border-gray-300">
                                </div>
                                @error('title')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Company -->
                            <!-- <div>
                                <div class="flex items-center mb-2">
                                    <label for="company_id" class="block text-sm font-semibold text-gray-800">
                                        Company
                                    </label>
                                    <span class="ml-1 text-red-500">*</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <select name="company_id" id="company_id" 
                                            required
                                            class="pl-10 block w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 appearance-none group-hover:border-gray-300">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('company_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div> -->

                            <!-- Category -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <label for="category_id" class="block text-sm font-semibold text-gray-800">
                                        Category
                                    </label>
                                    <span class="ml-1 text-red-500">*</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <select name="category_id" id="category_id" required
                                            class="pl-10 block w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 appearance-none group-hover:border-gray-300">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!-- <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div> -->
                                </div>
                                @error('category_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Job Description -->
                        <div>
                            <div class="flex items-center mb-2">
                                <label for="description" class="block text-sm font-semibold text-gray-800">
                                    Job Description
                                </label>
                                <span class="ml-1 text-red-500">*</span>
                            </div>
                            <div class="relative group">
                                <div class="absolute pt-5 left-3 my-auto">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                </div>
                                <textarea name="description" id="description" rows="6"
                                          placeholder="Provide a detailed description of the job role, responsibilities, and qualifications."
                                          required
                                          class="pl-10 block w-full px-4 py-4 rounded-xl border border-gray-200 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 group-hover:border-gray-300">{{ old('description') }}</textarea>
                            </div>
                            <!-- <div class="flex justify-between items-center mt-2">
                                <p class="text-xs text-gray-500">Detailed job description helps attract better candidates</p>
                                <span class="text-xs text-gray-400" id="char-count">0 characters</span>
                            </div> -->
                            @error('description')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Details -->
            <div class="px-8 py-8 bg-gray-50">
                <div class="mb-2">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-blue-50 rounded-lg mr-3">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Job Details</h3>
                        <!-- <span class="ml-2 text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">Required</span> -->
                    </div>
                    
                    <div class="space-y-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Location -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <label for="location" class="block text-sm font-semibold text-gray-800">
                                        Location
                                    </label>
                                    <span class="ml-1 text-red-500">*</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="location" id="location" 
                                           value="{{ old('location') }}"
                                           required
                                           class="pl-10 block w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 group-hover:border-gray-300"
                                           placeholder="e.g., New York, NY">
                                </div>
                                @error('location')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Job Type -->
                            <div>
                                <div class="flex items-center mb-2">
                                    <label for="job_type" class="block text-sm font-semibold text-gray-800">
                                        Job Type
                                    </label>
                                    <span class="ml-1 text-red-500">*</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <select name="job_type" id="job_type" required
                                            class="pl-10 block w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 appearance-none group-hover:border-gray-300">
                                        <option value="">Select Job Type</option>
                                        <option value="full-time" {{ old('job_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="part-time" {{ old('job_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                        <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="remote" {{ old('job_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                                        <option value="internship" {{ old('job_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                                        <option value="hybrid" {{ old('job_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    </select>
                                    <!-- <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div> -->
                                </div>
                                @error('job_type')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Experience Level -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <div class="flex items-center mb-2">
                                    <label for="experience_level" class="block text-sm font-semibold text-gray-800">
                                        Experience Level
                                    </label>
                                    <span class="ml-1 text-red-500">*</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <select name="experience_level" id="experience_level" required
                                            class="pl-10 block w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 appearance-none group-hover:border-gray-300">
                                        <option value="">Select Experience Level</option>
                                        <option value="intern" {{ old('experience_level') == 'intern' ? 'selected' : '' }}>Intern (Student)</option>
                                        <option value="junior" {{ old('experience_level') == 'junior' ? 'selected' : '' }}>Junior (0-2 years)</option>
                                        <option value="mid" {{ old('experience_level') == 'mid' ? 'selected' : '' }}>Mid Level (2-5 years)</option>
                                        <option value="senior" {{ old('experience_level') == 'senior' ? 'selected' : '' }}>Senior (5+ years)</option>
                                        <option value="lead" {{ old('experience_level') == 'lead' ? 'selected' : '' }}>Lead/Manager</option>
                                        <option value="executive" {{ old('experience_level') == 'executive' ? 'selected' : '' }}>Executive</option>
                                    </select>
                                    <!-- <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div> -->
                                </div>
                                @error('experience_level')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                            
                            <!-- Application Deadline -->
                            <div>                  

                                <div class="flex items-center mb-2">
                                    <label for="application_deadline" class="block text-sm font-semibold text-gray-800">
                                        Application Deadline
                                    </label>
                                    <span class="ml-1 text-red-500">*</span>
                                </div>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="date" name="application_deadline" id="application_deadline" required
                                           value="{{ old('application_deadline') }}"
                                           min="{{ date('Y-m-d') }}"
                                           class="pl-10 block w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 group-hover:border-gray-300">
                                </div>
                                @error('application_deadline')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Salary Information -->
            <div class="px-8 py-8">
                <div class="mb-2">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-blue-50 rounded-lg mr-3">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Salary Information</h3>
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Negotiable Toggle -->
                        <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Salary Negotiable</h4>
                                    <!-- <p class="text-sm text-gray-600 mt-1">Enable if salary range is flexible</p> -->
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_negotiable" id="is_negotiable" value="1" 
                                           {{ old('is_negotiable') ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>

                        

                        <!-- Salary Range -->
                        <div id="salary-range-container" class="mb-4">

                            <label class="block text-sm font-semibold text-gray-800 mb-3">
                                Salary Range (Monthly)
                            </label>

                            <!-- All in One Row -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                <!-- Currency -->
                                <div>
                                    <!-- <label for="salary_currency" class="block text-xs font-medium text-gray-600 mb-1">
                                        Currency
                                    </label> -->
                                    <div class="relative group">
                                        <select name="salary_currency" id="salary_currency"
                                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                            <option value="BDT">BDT (৳)</option>
                                            <option value="USD">USD ($)</option>
                                            <option value="EUR">EUR (€)</option>
                                            <option value="GBP">GBP (£)</option>
                                            <option value="BDT">BDT (৳)</option>
                                            <option value="INR">INR (₹)</option>
                                        </select>
                                        <!-- <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div> -->
                                    </div>
                                </div>

                                <!-- Minimum Salary -->
                                <div>
                                    <!-- <label class="block text-xs font-medium text-gray-600 mb-1">
                                        Minimum
                                    </label> -->
                                    <div class="relative">
                                        <!-- <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                            $
                                        </div> -->
                                        <input type="number" name="salary_min"
                                            placeholder="Min Salary"
                                            class="pl-8 w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </div>
                                </div>

                                <!-- Maximum Salary -->
                                <div>
                                    <!-- <label class="block text-xs font-medium text-gray-600 mb-1">
                                        Maximum
                                    </label> -->
                                    <div class="relative">
                                        <!-- <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                            $
                                        </div> -->
                                        <input type="number" name="salary_max"
                                            placeholder="Max Salary"
                                            class="pl-8 w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </div>
                                </div>

                            </div>

                            <p class="mt-3 text-xs text-gray-500 rounded-lg flex items-center gap-1">
                                <svg class="h-4 w-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Leave empty if salary is negotiable. Provide range for better candidate expectations.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requirements & Benefits -->
            <div class="px-8 py-8 bg-gray-50">
                <div class="mb-2">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-blue-50 rounded-lg mr-3">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Requirements & Benefits</h3>
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Skills Required -->
                        <div>
                            <label for="skills_required" class="block text-sm font-semibold text-gray-800 mb-2">
                                Skills Required
                            </label>
                            <div class="relative group">
                                <div class="absolute left-3 pt-5">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <textarea name="skills_required" id="skills_required" rows="4"
                                          placeholder="e.g., JavaScript, PHP, Laravel, React, Vue.js, Python, AWS"
                                          class="pl-10 block w-full px-4 py-4 rounded-xl border border-gray-200 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 group-hover:border-gray-300">{{ old('skills_required') }}</textarea>
                            </div>
                            <!-- <p class="mt-2 text-xs text-gray-500">Separate skills with commas. Add relevant technologies.</p> -->
                            <p class="mt-3 text-xs text-gray-500rounded-lg flex items-center gap-1">
                                <svg class="h-4 w-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-gray-500">Separate skills with commas. Add relevant technologies.</span>
                            </p>
                        </div>

                        <!-- Benefits -->
                        <div>
                            <label for="benefits" class="block text-sm font-semibold text-gray-800 mb-2">
                                Benefits
                            </label>
                            <div class="relative group">
                                <div class="absolute left-3 pt-5">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                    </svg>
                                </div>
                                <textarea name="benefits" id="benefits" rows="7"
                                          placeholder="Health Insurance&#10;Paid Time Off&#10;Remote Work Options&#10;Professional Development&#10;Stock Options&#10;Flexible Hours"
                                          class="pl-10 block w-full px-4 py-4 rounded-xl border border-gray-200 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 group-hover:border-gray-300">{{ old('benefits') }}</textarea>
                            </div>
                            <!-- <p class="mt-2 text-xs text-gray-500">Enter each benefit on a new line. Competitive benefits attract top talent.</p> -->
                            <p class="mt-3 text-xs text-gray-500rounded-lg flex items-center gap-1">
                                <svg class="h-4 w-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-gray-500">Enter each benefit on a new line. Competitive benefits attract top talent.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Settings -->
            <div class="px-8 py-8">
                <div class="mb-2">
                    <div class="flex items-center mb-6">
                        <div class="p-2 bg-blue-50 rounded-lg mr-3">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Additional Settings</h3>
                    </div>
                    
                    <div class="space-y-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Company Logo -->
                            <div>
                                <!-- <label for="company_logo" class="block text-sm font-semibold text-gray-800 mb-2">
                                    Company Logo
                                </label> -->
                                <div class="mt-1">
                                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 hover:border-blue-400 transition-colors duration-200 bg-gray-50 hover:bg-blue-50">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <div class="mt-2">
                                                <label for="company_logo" class="cursor-pointer">
                                                    <span class="inline-flex items-center px-4 py-2.5 text-blue-500 font-semibold rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                        </svg>
                                                        Upload Logo
                                                    </span>
                                                    <input type="file" name="company_logo" id="company_logo" 
                                                           accept="image/*"
                                                           class="sr-only">
                                                </label>
                                            </div>
                                            <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                            <p class="text-xs text-gray-400 mt-1">Will use company's default logo if not provided</p>
                                        </div>
                                    </div>
                                    <div id="logo-preview" class="hidden mt-4">
                                        <div class="flex items-center justify-between bg-blue-50 p-4 rounded-xl">
                                            <div class="flex items-center space-x-3">
                                                <img id="preview-image" class="h-12 w-12 rounded-lg object-cover border-2 border-white shadow" 
                                                     src="" alt="Logo preview">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Selected Logo</p>
                                                    <p class="text-xs text-gray-500">Ready to upload</p>
                                                </div>
                                            </div>
                                            <button type="button" 
                                                    onclick="removeLogoPreview()"
                                                    class="text-sm text-red-600 hover:text-red-800 font-medium">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Active -->
                            <div class="space-y-6">
                                <!-- Active Status -->
                                <div class="bg-white p-4 rounded-xl border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-blue-50 rounded-lg mr-3">
                                                <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">Active Status</h4>
                                                <!-- <p class="text-sm text-gray-600 mt-1">Make job visible to candidates</p> -->
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                                   {{ old('is_active', true) ? 'checked' : '' }}
                                                   class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Approval Status -->
                                <div class="bg-white p-5 rounded-xl border border-gray-200">
                                    <label for="status" class="block text-sm font-semibold text-gray-800 mb-2">
                                        Approval Status
                                    </label>
                                    <div class="relative group">
                                        <select name="status" id="status"
                                                class="block w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 appearance-none group-hover:border-gray-300">
                                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                            <!-- <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option> -->
                                        </select>
                                        <!-- <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div> -->
                                    </div>
                                    <!-- <p class="mt-2 text-xs text-gray-500">Admin jobs are usually auto-approved. Use "Draft" to save progress.</p> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-8 py-6 border-t border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center justify-between">
                    <!-- <div>
                        <p class="text-sm text-gray-600">
                            <span class="text-red-500">*</span> Indicates required field
                            <span class="mx-2">•</span>
                            <span id="form-progress">25% complete</span>
                        </p>
                    </div> -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.jobs.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            Cancel
                        </a>
                        <!-- <button type="button" id="save-draft-btn"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Save Draft
                        </button> -->
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-gray-500 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 hover:border-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <!-- <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg> -->
                            Create Job Posting
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Tips Sidebar -->
    <div class="">
        <div class="lg:w-2/3"></div>
        <div class="">
            <div class="bg-gradient-to-b from-blue-50 to-white rounded-2xl border border-blue-100 p-6 mb-6">
                <div class="flex items-center mb-4">
                    <!-- <div class="p-2 bg-blue-100 rounded-lg mr-3">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div> -->
                    <h4 class="font-bold text-gray-900">Notes:</h4>
                </div>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700">Be specific with job titles and descriptions</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700">Include detailed requirements to attract qualified candidates</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700">Competitive benefits increase application rates</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm text-gray-700">Set realistic deadlines for better planning</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Character count for description
const descriptionElement = document.getElementById('description');
if (descriptionElement) {
    descriptionElement.addEventListener('input', function(e) {
        const charCount = this.value.length;
        const charCountElement = document.getElementById('char-count');
        if (charCountElement) {
            charCountElement.textContent = charCount + ' characters';
        }
    });
}

// Handle negotiable checkbox
const negotiableCheckbox = document.getElementById('is_negotiable');
const salaryMin = document.getElementById('salary_min');
const salaryMax = document.getElementById('salary_max');
const salaryCurrency = document.getElementById('salary_currency');
const salaryContainer = document.getElementById('salary-range-container');
const currencyContainer = document.getElementById('currency-container');

function toggleSalaryFields() {
    if (negotiableCheckbox && negotiableCheckbox.checked) {
        if (salaryMin) salaryMin.disabled = true;
        if (salaryMax) salaryMax.disabled = true;
        if (salaryCurrency) salaryCurrency.disabled = true;
        if (salaryMin) salaryMin.value = '';
        if (salaryMax) salaryMax.value = '';
        if (salaryContainer) {
            salaryContainer.style.opacity = '0.5';
            salaryContainer.style.pointerEvents = 'none';
        }
        if (currencyContainer) {
            currencyContainer.style.opacity = '0.5';
            currencyContainer.style.pointerEvents = 'none';
        }
    } else {
        if (salaryMin) salaryMin.disabled = false;
        if (salaryMax) salaryMax.disabled = false;
        if (salaryCurrency) salaryCurrency.disabled = false;
        if (salaryContainer) {
            salaryContainer.style.opacity = '1';
            salaryContainer.style.pointerEvents = 'auto';
        }
        if (currencyContainer) {
            currencyContainer.style.opacity = '1';
            currencyContainer.style.pointerEvents = 'auto';
        }
    }
}

if (negotiableCheckbox) {
    negotiableCheckbox.addEventListener('change', toggleSalaryFields);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleSalaryFields();
    
    // Set minimum date for deadline to today
    const deadlineElement = document.getElementById('application_deadline');
    if (deadlineElement) {
        deadlineElement.min = new Date().toISOString().split('T')[0];
    }
    
    // Form progress calculation (removed as not needed - elements don't exist)
    // function updateFormProgress() {
    //     const requiredFields = document.querySelectorAll('input[required], textarea[required], select[required]');
    //     let filledCount = 0;
        
    //     requiredFields.forEach(field => {
    //         if (field.type === 'checkbox' || field.type === 'radio') {
    //             if (field.checked) filledCount++;
    //         } else if (field.value.trim() !== '') {
    //             filledCount++;
    //         }
    //     });
        
    //     const progress = Math.round((filledCount / requiredFields.length) * 100);
    //     const progressElement = document.getElementById('form-progress');
    //     if (progressElement) {
    //         progressElement.textContent = progress + '% complete';
    //     }
    // }
    
    // // Attach progress updates to all inputs
    // document.querySelectorAll('input, textarea, select').forEach(field => {
    //     field.addEventListener('input', updateFormProgress);
    //     field.addEventListener('change', updateFormProgress);
    // });
    
    // updateFormProgress();
});

// Auto-format skills input
const skillsElement = document.getElementById('skills_required');
if (skillsElement) {
    skillsElement.addEventListener('blur', function(e) {
        const skills = this.value.split(',').map(skill => skill.trim()).filter(skill => skill);
        this.value = skills.join(', ');
    });
}

// Auto-format benefits input
const benefitsElement = document.getElementById('benefits');
if (benefitsElement) {
    benefitsElement.addEventListener('blur', function(e) {
        const benefits = this.value.split('\n').map(benefit => benefit.trim()).filter(benefit => benefit);
        this.value = benefits.join('\n');
    });
}

// Logo preview functionality
const logoInput = document.getElementById('company_logo');
if (logoInput) {
    logoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-image');
                const logoPreview = document.getElementById('logo-preview');
                
                if (preview) preview.src = e.target.result;
                if (logoPreview) logoPreview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
}

function removeLogoPreview() {
    const input = document.getElementById('company_logo');
    const logoPreview = document.getElementById('logo-preview');
    
    if (input) input.value = '';
    if (logoPreview) logoPreview.classList.add('hidden');
}

// Save draft button
const saveDraftBtn = document.getElementById('save-draft-btn');
if (saveDraftBtn) {
    saveDraftBtn.addEventListener('click', function() {
        const statusElement = document.getElementById('status');
        if (statusElement) {
            statusElement.value = 'draft';
        }
        // Submit the form
        document.querySelector('form').submit();
    });
}
</script>
@endpush
@endsection