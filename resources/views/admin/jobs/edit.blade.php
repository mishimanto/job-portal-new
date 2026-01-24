@extends('layouts.admin')

@section('title', 'Edit ' . $job->title . ' - Admin Panel')
@section('page-title', 'Edit Job')
@section('page-subtitle', 'Update job posting details')

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
        <a href="{{ route('admin.jobs.show', $job) }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
            {{ Str::limit($job->title, 20) }}
        </a>
    </div>
</li>
<li>
    <div class="flex items-center">
        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
        </svg>
        <span class="ml-4 text-sm font-medium text-gray-500">
            Edit
        </span>
    </div>
</li>
@endsection

@section('content')
<div class="mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Job Status Badges -->
    <div class="my-6 flex flex-wrap gap-3">
        <div class="flex items-center">
            <div class="px-3 py-1.5 rounded-full text-xs font-semibold 
                {{ $job->status == 'approved' ? 'bg-green-100 text-green-800' : 
                   ($job->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   'bg-red-100 text-red-800') }}">
                {{ ucfirst($job->status) }}
            </div>
        </div>
        <div class="flex items-center">
            <div class="px-3 py-1.5 rounded-full text-xs font-semibold 
                {{ $job->is_active ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                {{ $job->is_active ? 'Active' : 'Inactive' }}
            </div>
        </div>
        <div class="flex items-center">
            <div class="px-3 py-1.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                {{ $job->job_type }}
            </div>
        </div>
        <div class="flex items-center">
            <div class="px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                {{ $job->experience_level }}
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-8">
        <!-- Form Content -->
        <form action="{{ route('admin.jobs.update', $job) }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
            @csrf
            @method('PUT')
            
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
                                           value="{{ old('title', $job->title) }}"
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
                                            @php
                                                $selected = old('company_id') ? old('company_id') : $job->company_id;
                                            @endphp
                                            <option value="{{ $company->id }}" {{ $selected == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                            <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                          class="pl-10 block w-full px-4 py-4 rounded-xl border border-gray-200 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 group-hover:border-gray-300">{{ old('description', $job->description) }}</textarea>
                            </div>
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
                                           value="{{ old('location', $job->location) }}"
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
                                        <option value="full-time" {{ old('job_type', $job->job_type) == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="part-time" {{ old('job_type', $job->job_type) == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                        <option value="contract" {{ old('job_type', $job->job_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                        <option value="remote" {{ old('job_type', $job->job_type) == 'remote' ? 'selected' : '' }}>Remote</option>
                                        <option value="internship" {{ old('job_type', $job->job_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                                        <option value="hybrid" {{ old('job_type', $job->job_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    </select>
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
                                        <option value="intern" {{ old('experience_level', $job->experience_level) == 'intern' ? 'selected' : '' }}>Intern (Student)</option>
                                        <option value="junior" {{ old('experience_level', $job->experience_level) == 'junior' ? 'selected' : '' }}>Junior (0-2 years)</option>
                                        <option value="mid" {{ old('experience_level', $job->experience_level) == 'mid' ? 'selected' : '' }}>Mid Level (2-5 years)</option>
                                        <option value="senior" {{ old('experience_level', $job->experience_level) == 'senior' ? 'selected' : '' }}>Senior (5+ years)</option>
                                        <option value="lead" {{ old('experience_level', $job->experience_level) == 'lead' ? 'selected' : '' }}>Lead/Manager</option>
                                        <option value="executive" {{ old('experience_level', $job->experience_level) == 'executive' ? 'selected' : '' }}>Executive</option>
                                    </select>
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
                                           value="{{ old('application_deadline', $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}"
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
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_negotiable" id="is_negotiable" value="1" 
                                           {{ old('is_negotiable', $job->is_negotiable) ? 'checked' : '' }}
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
                                    <div class="relative group">
                                        <select name="salary_currency" id="salary_currency"
                                            class="block w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                                            <option value="BDT" {{ old('salary_currency', $job->salary_currency) == 'BDT' ? 'selected' : '' }}>BDT (৳)</option>
                                            <option value="USD" {{ old('salary_currency', $job->salary_currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                            <option value="EUR" {{ old('salary_currency', $job->salary_currency) == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                            <option value="GBP" {{ old('salary_currency', $job->salary_currency) == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                            <option value="INR" {{ old('salary_currency', $job->salary_currency) == 'INR' ? 'selected' : '' }}>INR (₹)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Minimum Salary -->
                                <div>
                                    <div class="relative">
                                        <input type="number" name="salary_min" id="salary_min"
                                            value="{{ old('salary_min', $job->salary_min) }}"
                                            placeholder="Min Salary"
                                            class="pl-8 w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </div>
                                </div>

                                <!-- Maximum Salary -->
                                <div>
                                    <div class="relative">
                                        <input type="number" name="salary_max" id="salary_max"
                                            value="{{ old('salary_max', $job->salary_max) }}"
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
                                <div class="absolute top-4 left-3 pt-1">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <textarea name="skills_required" id="skills_required" rows="4"
                                          placeholder="e.g., JavaScript, PHP, Laravel, React, Vue.js, Python, AWS"
                                          class="pl-10 block w-full px-4 py-4 rounded-xl border border-gray-200 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 group-hover:border-gray-300">{{ old('skills_required', is_array($job->skills_required) ? implode(', ', $job->skills_required) : $job->skills_required) }}</textarea>
                            </div>
                            <p class="mt-3 text-xs text-gray-500 rounded-lg flex items-center gap-1">
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
                                <div class="absolute top-4 left-3 pt-1">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                    </svg>
                                </div>
                                <textarea name="benefits" id="benefits" rows="7"
                                          placeholder="Health Insurance&#10;Paid Time Off&#10;Remote Work Options&#10;Professional Development&#10;Stock Options&#10;Flexible Hours"
                                          class="pl-10 block w-full px-4 py-4 rounded-xl border border-gray-200 bg-gray-50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent focus:bg-white transition-all duration-200 group-hover:border-gray-300">{{ old('benefits', is_array($job->benefits) ? implode("\n", $job->benefits) : $job->benefits) }}</textarea>
                            </div>
                            <p class="mt-3 text-xs text-gray-500 rounded-lg flex items-center gap-1">
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
                                <div class="mt-1">
                                    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-6 hover:border-blue-400 transition-colors duration-200 bg-gray-50 hover:bg-blue-50 relative">
                                        
                                        <div class="text-center">
                                            @if($job->company_logo)
                                            <div id="current-logo-container" 
                                                class="mb-4 flex items-center justify-between bg-white px-3 py-2 rounded-md border border-gray-200 max-w-xs mx-auto">
                                                
                                                <div class="flex items-center space-x-2">
                                                    <img src="{{ Storage::url($job->company_logo) }}" 
                                                        alt="{{ $job->company->name ?? 'Company' }} Logo"
                                                        class="h-10 w-10 rounded-lg object-cover border border-gray-200">
                                                    <span class="text-sm font-medium truncate">Current Logo</span>
                                                </div>

                                                <button type="button" 
                                                        onclick="removeCurrentLogo()"
                                                        class="text-xs text-red-600 hover:text-red-800 font-medium px-2 py-1 rounded-md hover:bg-red-50 transition-colors">
                                                    Remove
                                                </button>
                                            </div>
                                            @endif
                                            
                                            <div class="mt-2">
                                                <label for="company_logo" class="cursor-pointer">
                                                    <span class="inline-flex items-center px-4 py-2.5 text-blue-500 font-semibold rounded-lg hover:bg-gray-200 transition-colors duration-200">
                                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                        </svg>
                                                        {{ $job->company_logo ? 'Change Logo' : 'Upload Logo' }}
                                                    </span>
                                                    <input type="file" name="company_logo" id="company_logo" 
                                                           accept="image/*"
                                                           class="sr-only">
                                                </label>
                                            </div>
                                            <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                        </div>

                                        <!-- New Logo Preview (shows in same position as current logo) -->
                                        <div id="logo-preview" class="hidden">
                                            <div class="mt-2 mb-4 flex items-center justify-between bg-white px-3 py-2 rounded-md border border-gray-200 max-w-xs mx-auto">
                                                <div class="flex items-center space-x-2">
                                                    <img id="preview-image" class="h-10 w-10 rounded-lg object-cover border border-gray-200" 
                                                         src="" alt="New logo preview">
                                                    <span class="text-sm font-medium truncate">New Logo</span>
                                                </div>
                                                <button type="button" 
                                                        onclick="removeLogoPreview()"
                                                        class="text-xs text-red-600 hover:text-red-800 font-medium px-2 py-1 rounded-md hover:bg-red-50 transition-colors">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Hidden field for logo removal -->
                                @if($job->company_logo)
                                    <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                                @endif
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
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                                   {{ old('is_active', $job->is_active) ? 'checked' : '' }}
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
                                            <option value="approved" {{ old('status', $job->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="pending" {{ old('status', $job->status) == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                            <option value="rejected" {{ old('status', $job->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-8 py-6 border-t border-gray-200 bg-gradient-to-r from-blue-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.jobs.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-gray-500 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 hover:border-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">
                            <!-- <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg> -->
                            Update Job Posting
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
document.getElementById('description').addEventListener('input', function(e) {
    const charCount = this.value.length;
});

// Handle negotiable checkbox
const negotiableCheckbox = document.getElementById('is_negotiable');
const salaryMin = document.getElementById('salary_min');
const salaryMax = document.getElementById('salary_max');
const salaryCurrency = document.getElementById('salary_currency');
const salaryContainer = document.getElementById('salary-range-container');

function toggleSalaryFields() {
    if (negotiableCheckbox.checked) {
        salaryMin.disabled = true;
        salaryMax.disabled = true;
        salaryCurrency.disabled = true;
        salaryMin.value = '';
        salaryMax.value = '';
        salaryContainer.style.opacity = '0.5';
        salaryContainer.style.pointerEvents = 'none';
    } else {
        salaryMin.disabled = false;
        salaryMax.disabled = false;
        salaryCurrency.disabled = false;
        salaryContainer.style.opacity = '1';
        salaryContainer.style.pointerEvents = 'auto';
    }
}

negotiableCheckbox.addEventListener('change', toggleSalaryFields);

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleSalaryFields();
    
    // Set minimum date for deadline to today
    document.getElementById('application_deadline').min = new Date().toISOString().split('T')[0];
});

// Auto-format skills input
document.getElementById('skills_required').addEventListener('blur', function(e) {
    const skills = this.value.split(',').map(skill => skill.trim()).filter(skill => skill);
    this.value = skills.join(', ');
});

// Auto-format benefits input
document.getElementById('benefits').addEventListener('blur', function(e) {
    const benefits = this.value.split('\n').map(benefit => benefit.trim()).filter(benefit => benefit);
    this.value = benefits.join('\n');
});

// Logo preview functionality
const companyLogoInput = document.getElementById('company_logo');
if (companyLogoInput) {
    companyLogoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview-image');
                const logoPreview = document.getElementById('logo-preview');
                
                if (preview && logoPreview) {
                    preview.src = e.target.result;
                    logoPreview.classList.remove('hidden');
                    
                    // Hide current logo when new one is selected
                    const currentLogoContainer = document.getElementById('current-logo-container');
                    if (currentLogoContainer) {
                        currentLogoContainer.classList.add('hidden');
                    }
                }
            }
            reader.readAsDataURL(file);
        }
    });
}

function removeLogoPreview() {
    const input = document.getElementById('company_logo');
    const logoPreview = document.getElementById('logo-preview');
    
    if (input && logoPreview) {
        input.value = '';
        logoPreview.classList.add('hidden');
        
        // Show current logo again if exists
        const currentLogoContainer = document.getElementById('current-logo-container');
        if (currentLogoContainer) {
            currentLogoContainer.classList.remove('hidden');
        }
    }
}

function removeCurrentLogo() {
    // SweetAlert 2 confirmation
    Swal.fire({
        title: 'Remove Current Logo?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: 'gray',
        confirmButtonText: 'Yes, remove it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
            confirmButton: 'px-4 py-2 rounded-lg',
            cancelButton: 'px-4 py-2 rounded-lg'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const removeLogoInput = document.getElementById('remove_logo');
            if (removeLogoInput) {
                removeLogoInput.value = '1';
            }
            
            // Hide current logo container
            const currentLogoContainer = document.getElementById('current-logo-container');
            if (currentLogoContainer) {
                currentLogoContainer.classList.add('hidden');
            }
            
            // Reset file input if any
            const fileInput = document.getElementById('company_logo');
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Hide new logo preview if visible
            const logoPreview = document.getElementById('logo-preview');
            if (logoPreview) {
                logoPreview.classList.add('hidden');
            }
            
            // Show success message
            Swal.fire(
                'Removed!',
                'Current logo has been removed.',
                'success'
            );
        }
    });
}

// Update is_active based on status selection
const statusSelect = document.getElementById('status');
if (statusSelect) {
    statusSelect.addEventListener('change', function(e) {
        const isActiveCheckbox = document.getElementById('is_active');
        if (this.value === 'approved') {
            isActiveCheckbox.checked = true;
        } else if (this.value === 'rejected') {
            isActiveCheckbox.checked = false;
        }
    });
}
</script>
@endpush
@endsection