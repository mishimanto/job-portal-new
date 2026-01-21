@extends('layouts.admin')

@section('title', 'Application Details - Admin Panel')
@section('page-title', 'Application Details')

@section('breadcrumbs')
<li>
    <div class="flex items-center">
        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
        </svg>
        <a href="{{ route('admin.applications.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
            Applications
        </a>
    </div>
</li>
<li>
    <div class="flex items-center">
        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
        </svg>
        <span class="ml-4 text-sm font-medium text-gray-500">
            Details
        </span>
    </div>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Application Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Application #{{ $application->id }} 
                    </h3>
                    <p class="mt-1 text-sm text-gray-300">
                        Applied {{ $application->applied_at->diffForHumans() }}
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium
                        @if($application->status == 'hired') bg-green-100 text-green-800
                        @elseif($application->status == 'shortlisted') bg-blue-100 text-blue-800
                        @elseif($application->status == 'reviewed') bg-yellow-100 text-yellow-800
                        @elseif($application->status == 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Applicant Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cover Letter -->
            @if($application->cover_letter)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Cover Letter
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="prose max-w-none">
                        {!! nl2br(e($application->cover_letter)) !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Job Details -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Job Details
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $application->job->title }}</h4>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Company</p>
                            <p class="text-sm text-gray-900">{{ $application->job->company_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Location</p>
                            <p class="text-sm text-gray-900">{{ $application->job->location }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Job Type</p>
                            <p class="text-sm text-gray-900">{{ ucfirst($application->job->job_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Experience Level</p>
                            <p class="text-sm text-gray-900">{{ ucfirst($application->job->experience_level) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Salary</p>
                            <p class="text-sm text-gray-900">
                                @if($application->job->salary_min && $application->job->salary_max)
                                    {{ $application->job->salary_currency ?? 'USD' }} 
                                    {{ number_format($application->job->salary_min, 2) }} - 
                                    {{ number_format($application->job->salary_max, 2) }}
                                @elseif($application->job->salary)
                                    {{ $application->job->salary }}
                                @else
                                    Not specified
                                @endif
                                
                                @if($application->job->is_negotiable)
                                    <span class="ml-2 text-xs text-green-600 font-medium">(Negotiable)</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Deadline</p>
                            <p class="text-sm text-gray-900">{{ $application->job->application_deadline?->format('M d, Y') ?? 'Not specified' }}</p>
                        </div>
                    </div>
                    @if($application->job->description)
                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-500 mb-2">Job Description</p>
                        <div class="prose max-w-none text-sm text-gray-700">
                            {!! nl2br(e($application->job->description)) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Applicant Details -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Applicant Information
                    </h3>                    
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            @if($application->user->profile_photo)
                                <img src="{{ Storage::url($application->user->profile_photo) }}" 
                                     alt="Profile Photo" 
                                     class="h-16 w-16 rounded-full object-cover border-2 border-white shadow-md">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                    <span class="text-white font-bold text-xl">
                                        {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $application->user->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $application->user->email }}</p>
                            <p class="text-sm text-gray-600">{{ $application->user->phone ?? 'No phone number' }}</p>
                            @if($application->user->address)
                            <p class="text-sm text-gray-600">{{ $application->user->address }}</p>
                            @endif
                            
                            @if($application->resume)
                            <a href="{{ Storage::url($application->resume) }}" 
                               target="_blank"
                               class="inline-flex items-center mt-2 text-sm text-indigo-600 hover:text-indigo-900">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                View Resume
                            </a>
                            @endif

                            <!-- Custom Email Button -->
                            <div class="">
                                <button onclick="openCustomEmailModal()" 
                                        class="inline-flex items-center mt-2 text-sm text-indigo-600 hover:text-indigo-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Send Custom Message
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Seeker Profile Information -->
            <div class="bg-white shadow rounded-lg mt-6">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Job Seeker Profile Details
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 mb-6">
                        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                            <button onclick="showTab('personal')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                    id="personal-tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Personal Info
                            </button>
                            <button onclick="showTab('education')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                    id="education-tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                                Education
                            </button>
                            <button onclick="showTab('experience')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                    id="experience-tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Experience
                            </button>
                            <button onclick="showTab('skills')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                    id="skills-tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Skills
                            </button>
                            <button onclick="showTab('projects')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                    id="projects-tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Projects
                            </button>
                            <button onclick="showTab('certifications')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                    id="certifications-tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                                Certifications
                            </button>
                            <button onclick="showTab('social')" 
                                    class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                                    id="social-tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                Social Links
                            </button>
                        </nav>
                    </div>

                    <!-- Personal Information Tab -->
                    <div id="personal-tab-content" class="tab-content active">
                        @php
                            $personalInfo = $application->user->personalInformation;
                            $jobSeekerProfile = $application->user->jobSeekerProfile;
                        @endphp
                        
                        @if($personalInfo || $jobSeekerProfile)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Personal Details -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-900 border-b pb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                    Personal Details
                                </h4>
                                
                                <div class="space-y-3">
                                    @if($personalInfo)
                                        @if($personalInfo->first_name || $personalInfo->last_name)
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">Full Name</span>
                                            <span class="text-sm text-gray-900">
                                                {{ $personalInfo->first_name }} {{ $personalInfo->last_name }}
                                            </span>
                                        </div>
                                        @endif
                                        
                                        @if($personalInfo->phone)
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">Phone</span>
                                            <span class="text-sm text-gray-900">{{ $personalInfo->phone }}</span>
                                        </div>
                                        @endif
                                        
                                        @if($personalInfo->date_of_birth)
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">Date of Birth</span>
                                            <span class="text-sm text-gray-900">
                                                {{ \Carbon\Carbon::parse($personalInfo->date_of_birth)->format('d M, Y') }}
                                            </span>
                                        </div>
                                        @endif
                                        
                                        @if($personalInfo->gender)
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">Gender</span>
                                            <span class="text-sm text-gray-900 capitalize">{{ $personalInfo->gender }}</span>
                                        </div>
                                        @endif
                                        
                                        @if($personalInfo->marital_status)
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">Marital Status</span>
                                            <span class="text-sm text-gray-900 capitalize">{{ $personalInfo->marital_status }}</span>
                                        </div>
                                        @endif
                                        
                                        @if($personalInfo->bio)
                                        <div class="mt-4">
                                            <span class="text-sm font-medium text-gray-500 block mb-2">Bio</span>
                                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $personalInfo->bio }}</p>
                                        </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Address & Professional Info -->
                            <div class="space-y-4">
                                <!-- Address Information -->
                                @if($personalInfo && ($personalInfo->address || $personalInfo->city || $personalInfo->country))
                                <div class="space-y-3">
                                    <h4 class="text-md font-semibold text-gray-900 border-b pb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Address
                                    </h4>
                                    
                                    @if($personalInfo->address)
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Address</span>
                                        <span class="text-sm text-gray-900 text-right">{{ $personalInfo->address }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($personalInfo->city)
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">City</span>
                                        <span class="text-sm text-gray-900">{{ $personalInfo->city }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($personalInfo->state)
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">State</span>
                                        <span class="text-sm text-gray-900">{{ $personalInfo->state }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($personalInfo->country)
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Country</span>
                                        <span class="text-sm text-gray-900">{{ $personalInfo->country }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($personalInfo->zip_code)
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">ZIP Code</span>
                                        <span class="text-sm text-gray-900">{{ $personalInfo->zip_code }}</span>
                                    </div>
                                    @endif
                                </div>
                                @endif
                                
                                <!-- Professional Information -->
                                @if($jobSeekerProfile)
                                <div class="space-y-3 mt-4">
                                    <h4 class="text-md font-semibold text-gray-900 border-b pb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Professional Info
                                    </h4>
                                    
                                    @if($jobSeekerProfile->title)
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Job Title</span>
                                        <span class="text-sm text-gray-900">{{ $jobSeekerProfile->title }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($jobSeekerProfile->experience_level)
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Experience Level</span>
                                        <span class="text-sm text-gray-900 capitalize">{{ $jobSeekerProfile->experience_level }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($jobSeekerProfile->education)
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Highest Education</span>
                                        <span class="text-sm text-gray-900 capitalize">{{ str_replace('_', ' ', $jobSeekerProfile->education) }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($jobSeekerProfile->summary)
                                    <div class="mt-4">
                                        <span class="text-sm font-medium text-gray-500 block mb-2">Professional Summary</span>
                                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $jobSeekerProfile->summary }}</p>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p class="text-gray-500">No profile information available</p>
                            <p class="text-gray-400 text-sm mt-1">Candidate hasn't completed their profile yet</p>
                        </div>
                        @endif
                    </div>

                    <!-- Education Tab -->
                    <div id="education-tab-content" class="tab-content hidden">
                        @if($application->user->educations && $application->user->educations->count() > 0)
                        <div class="space-y-4">
                            @foreach($application->user->educations as $education)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $education->degree }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ $education->institution }}</p>
                                        
                                        @if($education->field_of_study)
                                        <p class="text-gray-500 text-sm mt-1">Field: {{ $education->field_of_study }}</p>
                                        @endif
                                        
                                        <div class="flex items-center mt-2 text-sm text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($education->start_date)->format('M Y') }} - 
                                            {{ $education->is_current ? 'Present' : ($education->end_date ? \Carbon\Carbon::parse($education->end_date)->format('M Y') : '') }}</span>
                                        </div>
                                        
                                        @if($education->grade)
                                        <div class="mt-2">
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Grade: {{ $education->grade }}</span>
                                        </div>
                                        @endif
                                        
                                        @if($education->description)
                                        <p class="mt-3 text-gray-700 text-sm">{{ $education->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                            <p class="text-gray-500">No education information available</p>
                        </div>
                        @endif
                    </div>

                    <!-- Experience Tab -->
                    <div id="experience-tab-content" class="tab-content hidden">
                        @if($application->user->experiences && $application->user->experiences->count() > 0)
                        <div class="space-y-4">
                            @foreach($application->user->experiences as $experience)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $experience->job_title }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ $experience->company_name }}</p>
                                        
                                        <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-500">
                                            @if($experience->employment_type)
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ ucfirst($experience->employment_type) }}
                                            </span>
                                            @endif
                                            
                                            @if($experience->location)
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $experience->location }}
                                            </span>
                                            @endif
                                            
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                                                {{ $experience->is_current ? 'Present' : ($experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : '') }}
                                            </span>
                                        </div>
                                        
                                        @if($experience->description)
                                        <p class="mt-3 text-gray-700 text-sm">{{ $experience->description }}</p>
                                        @endif
                                        
                                        @if($experience->industry)
                                        <div class="mt-2">
                                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Industry: {{ $experience->industry }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500">No work experience available</p>
                        </div>
                        @endif
                    </div>

                    <!-- Skills Tab -->
                    <div id="skills-tab-content" class="tab-content hidden">
                        @if($application->user->skills && $application->user->skills->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($application->user->skills as $skill)
                            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-3 py-1.5 rounded-full flex items-center">
                                {{ $skill->name }}
                                @if($skill->level)
                                <span class="ml-1.5 text-xs bg-blue-100 px-1.5 py-0.5 rounded">({{ ucfirst($skill->level) }})</span>
                                @endif
                                @if($skill->years_of_experience)
                                <span class="ml-1.5 text-xs bg-blue-100 px-1.5 py-0.5 rounded">{{ $skill->years_of_experience }}y</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-gray-500">No skills information available</p>
                        </div>
                        @endif
                    </div>

                    <!-- Projects Tab -->
                    <div id="projects-tab-content" class="tab-content hidden">
                        @if($application->user->projects && $application->user->projects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($application->user->projects as $project)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <h4 class="font-medium text-gray-900">{{ $project->title }}</h4>
                                
                                @if($project->role)
                                <p class="text-sm text-gray-600 mt-1">{{ $project->role }}</p>
                                @endif
                                
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($project->start_date)->format('M Y') }} - 
                                    {{ $project->is_ongoing ? 'Present' : ($project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('M Y') : '') }}</span>
                                </div>
                                
                                @if($project->description)
                                <p class="mt-3 text-gray-700 text-sm">{{ Str::limit($project->description, 100) }}</p>
                                @endif
                                
                                @if($project->project_url)
                                <a href="{{ $project->project_url }}" target="_blank" 
                                   class="inline-flex items-center mt-3 text-blue-600 hover:text-blue-800 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    View Project
                                </a>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <p class="text-gray-500">No projects available</p>
                        </div>
                        @endif
                    </div>

                    <!-- Certifications Tab -->
                    <div id="certifications-tab-content" class="tab-content hidden">
                        @if($application->user->certifications && $application->user->certifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($application->user->certifications as $certification)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <h4 class="font-medium text-gray-900">{{ $certification->name }}</h4>
                                <p class="text-gray-600 text-sm mt-1">{{ $certification->issuing_organization }}</p>
                                
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>

                                    <span>
                                        <span class="text-gray-700">Issued:</span> {{ \Carbon\Carbon::parse($certification->issue_date)->format('M d, Y') }}
                                    </span>

                                    @if($certification->expiration_date)
                                        <span class="ml-4 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>

                                            <span>
                                                <span class="text-gray-700">Expires:</span> {{ \Carbon\Carbon::parse($certification->expiration_date)->format('M d, Y') }}
                                            </span>
                                        </span>
                                    @endif
                                </div>
                                
                                @if($certification->credential_id)
                                <p class="mt-2 text-sm text-gray-600">Credential ID: {{ $certification->credential_id }}</p>
                                @endif
                                
                                @if($certification->credential_url)
                                <a href="{{ $certification->credential_url }}" target="_blank" 
                                   class="inline-flex items-center mt-2 text-blue-600 hover:text-blue-800 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    View Credential
                                </a>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <p class="text-gray-500">No certifications available</p>
                        </div>
                        @endif
                    </div>

                    <!-- Social Links Tab -->
                    <div id="social-tab-content" class="tab-content hidden">
                        @if($application->user->socialLinks && $application->user->socialLinks->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($application->user->socialLinks as $link)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                        @switch($link->platform)
                                            @case('linkedin') 
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                                </svg>
                                                @break
                                            
                                            @case('github') 
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                                </svg>
                                                @break
                                            
                                            @case('twitter') 
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.213c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                                </svg>
                                                @break
                                            
                                            @case('facebook') 
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                </svg>
                                                @break
                                            
                                            @case('instagram') 
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                @break
                                            
                                            @case('website') 
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                                </svg>
                                                @break
                                            
                                            @default 
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                </svg>
                                        @endswitch
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ ucfirst($link->platform) }}</h4>
                                        <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm block truncate">
                                            {{ $link->url }}
                                        </a>
                                        @if($link->username)
                                        <p class="text-xs text-gray-500 mt-0.5">Username: {{ $link->username }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            <p class="text-gray-500">No social links available</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom Email Modal -->
        <div id="customEmailModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Send Custom Message</h3>
                        <button onclick="closeCustomEmailModal()" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <form id="customEmailForm">
                        @csrf
                        <input type="hidden" name="application_id" value="{{ $application->id }}">
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                To: <span class="font-semibold">{{ $application->user->email }}</span>
                            </label>
                            <div class="bg-gray-50 p-3 rounded-lg">
                                <p class="text-sm">
                                    <strong>Applicant:</strong> {{ $application->user->name }}<br>
                                    <strong>Job:</strong> {{ $application->job->title }}<br>
                                    <strong>Current Status:</strong> <span class="font-semibold">{{ ucfirst($application->status) }}</span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="custom_message" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Message *
                            </label>
                            <textarea 
                                name="message" 
                                id="custom_message" 
                                rows="6"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Write your custom message here..."
                                required></textarea>
                            <p class="mt-1 text-xs text-gray-500">
                                This message will be sent as an email to the applicant.
                            </p>
                        </div>
                        
                        <div id="emailResponse" class="hidden mb-4"></div>
                        
                        <div class="flex justify-end space-x-3">
                            <button 
                                type="button"
                                onclick="closeCustomEmailModal()"
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                id="sendEmailBtn"
                                class="px-4 py-2 bg-blue-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <span id="sendBtnText">Send Message</span>
                                <span id="loadingSpinner" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Sending...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->

        <div class="space-y-6">
            <!-- Application Notes -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Application Notes
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <form method="POST" action="{{ route('admin.applications.update-status', $application) }}" id="statusForm">
                        @csrf
                        @method('POST')
                        <div class="space-y-4">
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">
                                    Internal Notes
                                </label>
                                <textarea name="notes" id="notes" rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Add internal notes about this application...">{{ $application->notes }}</textarea>
                            </div>
                            
                            <div>
                                <label for="status_select" class="block text-sm font-medium text-gray-700">
                                    Update Status
                                </label>
                                <select name="status" id="status_select" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        onchange="toggleAdditionalFields()">
                                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewed" {{ $application->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                    <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="hired" {{ $application->status == 'hired' ? 'selected' : '' }}>Hired</option>
                                </select>
                            </div>
                            
                            <!-- Interview Time Field (for shortlisted) -->
                            <div id="interview_time_field" style="display: none;">
                                <label for="interview_time" class="block text-sm font-medium text-gray-700">
                                    Interview Time & Date <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" 
                                    name="interview_time" 
                                    id="interview_time"
                                    value="{{ $interviewTime ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="mt-1 text-xs text-gray-500">
                                    Required for shortlisted status. Candidate will receive email with this time.
                                </p>
                            </div>
                            
                            <!-- Joining Date Field (for hired) -->
                            <div id="joining_date_field" style="display: none;">
                                <label for="joining_date" class="block text-sm font-medium text-gray-700">
                                    Joining Date *
                                </label>
                                <input type="date" 
                                    name="joining_date" 
                                    id="joining_date"
                                    value="{{ $joiningDate ?? '' }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="mt-1 text-xs text-gray-500">
                                    Required for hired status. Candidate will receive email with this date.
                                </p>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-700 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save Updates
                            </button>

                        </div>
                    </form>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('admin.applications.destroy', $application) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this application?')"
                                class="w-full inline-flex justify-center py-2 px-4 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Application
                        </button>
                    </form>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Application Timeline
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-6">
                        <!-- Applied -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Applied for the job</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $application->applied_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>

                        <!-- Reviewed -->
                        @if($application->reviewed_at)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Reviewed by admin</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($application->reviewed_at)->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Shortlisted -->
                        @if($application->status == 'shortlisted' || $application->status == 'hired')
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="h-10 w-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Shortlisted</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $application->updated_at->format('M d, Y h:i A') }}
                                </p>
                                @if($application->interview_notes && isset($application->interview_notes['interview_time']))
                                <p class="text-xs text-blue-600 mt-2 font-medium">
                                    Interview: {{ \Carbon\Carbon::parse($application->interview_notes['interview_time'])->format('M d, Y h:i A') }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Interview Scheduled -->
                        @if($application->interview_notes && isset($application->interview_notes['interview_time']))
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="h-10 w-10 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Interview Scheduled</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($application->interview_notes['interview_time'])->format('M d, Y h:i A') }}
                                </p>
                                @if(isset($application->interview_notes['email_sent_at']))
                                <p class="text-xs text-green-600 mt-2 font-medium">
                                    Email sent: {{ \Carbon\Carbon::parse($application->interview_notes['email_sent_at'])->format('M d, Y h:i A') }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Hired -->
                        @if($application->status == 'hired')
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="h-10 w-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Hired</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $application->updated_at->format('M d, Y h:i A') }}
                                </p>
                                @if($application->interview_notes && isset($application->interview_notes['joining_date']))
                                <p class="text-xs text-green-600 mt-2 font-medium">
                                    Joining Date: {{ \Carbon\Carbon::parse($application->interview_notes['joining_date'])->format('M d, Y') }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Rejected -->
                        @if($application->status == 'rejected')
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="h-10 w-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Rejected</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $application->updated_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- Current Status -->
                        @if(!in_array($application->status, ['hired', 'rejected']))
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Current Status</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($application->status == 'pending') bg-gray-100 text-gray-800
                                        @elseif($application->status == 'reviewed') bg-blue-100 text-blue-800
                                        @elseif($application->status == 'shortlisted') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                    @if($application->status == 'pending')
                                    <span class="text-xs text-gray-500">Awaiting review</span>
                                    @elseif($application->status == 'reviewed')
                                    <span class="text-xs text-gray-500">Next steps pending</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Resume Preview -->
                @if($application->resume)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Resume Preview
                            </h3>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.applications.resume-preview', $application) }}" 
                                target="_blank"
                                class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Open New Tab
                                </a>
                                <a href="{{ Storage::url($application->resume) }}" 
                                download
                                class="text-sm font-medium text-green-600 hover:text-green-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50" style="height: 500px;">
                            <iframe 
                                src="{{ route('admin.applications.resume-preview', $application) }}"
                                id="resume-iframe"
                                class="w-full h-full"
                                frameborder="0"
                                title="Resume Preview"
                                allow="autoplay">
                                <div class="flex flex-col items-center justify-center h-full p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                    <h4 class="text-lg font-medium text-gray-700 mb-2">Resume Preview Unavailable</h4>
                                    <p class="text-gray-500 text-center mb-4">
                                        Your browser doesn't support PDF preview. Please download the resume.
                                    </p>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.applications.resume-preview', $application) }}" 
                                        target="_blank"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        Open in New Tab
                                        </a>
                                        <a href="{{ Storage::url($application->resume) }}" 
                                        download
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Download Resume
                                        </a>
                                    </div>
                                </div>
                            </iframe>
                        </div>
                        
                        <!-- PDF Controls -->
                        <div class="mt-3 flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <span>PDF Viewer</span>
                            </div>
                            
                            <div class="flex items-center space-x-1">
                                <button onclick="zoomOutResume()" 
                                        class="p-1.5 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded"
                                        title="Zoom Out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                                    </svg>
                                </button>
                                
                                <span id="zoom-level" class="text-sm text-gray-700 font-medium px-2">100%</span>
                                
                                <button onclick="zoomInResume()" 
                                        class="p-1.5 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded"
                                        title="Zoom In">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </button>
                                
                                <button onclick="resetZoomResume()" 
                                        class="ml-2 px-2 py-1 text-xs border border-gray-300 text-gray-700 hover:bg-gray-50 rounded"
                                        title="Reset Zoom">
                                    Reset
                                </button>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500">
                                    Page: 
                                    <select id="page-select" onchange="goToPage(this.value)" class="ml-1 border-gray-300 rounded text-xs">
                                        <option value="1">1</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                        
                        <!-- File Info -->
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>Uploaded: {{ $application->applied_at->format('M d, Y') }}</span>
                                </div>
                                <!-- <div>
                                    <span id="file-size">Loading...</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                @else

                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500">No resume uploaded</p>
                            <p class="text-gray-400 text-sm mt-1">Candidate didn't attach a resume</p>
                        </div>
                    </div>
                </div>
                @endif
                </div>
            </div>
        </div>

        <style>
            .tab-button {
                border-color: transparent;
                color: #6b7280;
            }

            .tab-button:hover {
                color: #374151;
                border-color: #d1d5db;
            }

            .tab-button.active {
                color: #4f46e5;
                border-color: #4f46e5;
            }

            .tab-content {
                display: none;
            }

            .tab-content.active {
                display: block;
                animation: fadeIn 0.3s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            </style>

            <style>
            /* Modal Animation */
            #customEmailModal {
                animation: fadeIn 0.3s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
        </style>

<script>
    // Tab Management
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
            content.classList.add('hidden');
        });
        
        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
            button.classList.remove('border-indigo-500', 'text-indigo-600');
            button.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        const tabContent = document.getElementById(tabName + '-tab-content');
        if (tabContent) {
            tabContent.classList.remove('hidden');
            tabContent.classList.add('active');
        }
        
        // Add active class to selected tab button
        const tabButton = document.getElementById(tabName + '-tab');
        if (tabButton) {
            tabButton.classList.remove('border-transparent', 'text-gray-500');
            tabButton.classList.add('active', 'border-indigo-500', 'text-indigo-600');
        }
    }

    // Status Form Additional Fields
    function toggleAdditionalFields() {
        const status = document.getElementById('status_select').value;
        const interviewField = document.getElementById('interview_time_field');
        const joiningField = document.getElementById('joining_date_field');
        
        // Hide both fields first
        interviewField.style.display = 'none';
        joiningField.style.display = 'none';
        
        // Show appropriate field based on status
        if (status === 'shortlisted') {
            interviewField.style.display = 'block';
        } else if (status === 'hired') {
            joiningField.style.display = 'block';
        }
    }

    // Form validation
    document.getElementById('statusForm').addEventListener('submit', function(e) {
        const status = document.getElementById('status_select').value;
        const interviewTime = document.getElementById('interview_time');
        const joiningDate = document.getElementById('joining_date');
        
        if (status === 'shortlisted' && (!interviewTime || !interviewTime.value)) {
            e.preventDefault();
            alert('Please enter interview time for shortlisted status.');
            interviewTime.focus();
        }
        
        if (status === 'hired' && (!joiningDate || !joiningDate.value)) {
            e.preventDefault();
            alert('Please enter joining date for hired status.');
            joiningDate.focus();
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize first tab as active
        showTab('personal');
        
        // Initialize status form fields
        toggleAdditionalFields();
    });

    // Resume zoom functionality
    let resumeZoom = 100;

    function zoomInResume() {
        const iframe = document.querySelector('#resume-iframe');
        resumeZoom = Math.min(resumeZoom + 20, 200);
        iframe.style.transform = `scale(${resumeZoom / 100})`;
        iframe.style.transformOrigin = 'top left';
    }

    function zoomOutResume() {
        const iframe = document.querySelector('#resume-iframe');
        resumeZoom = Math.max(resumeZoom - 20, 50);
        iframe.style.transform = `scale(${resumeZoom / 100})`;
        iframe.style.transformOrigin = 'top left';
    }

    // Iframe-এ id যোগ করুন
    document.addEventListener('DOMContentLoaded', function() {
        const iframe = document.querySelector('iframe[title="Resume Preview"]');
        if (iframe) {
            iframe.id = 'resume-iframe';
        }
    });
</script>

<script>
// Custom Email Modal Functions
function openCustomEmailModal() {
    document.getElementById('customEmailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCustomEmailModal() {
    document.getElementById('customEmailModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    resetEmailForm();
}

function resetEmailForm() {
    document.getElementById('custom_message').value = '';
    document.getElementById('emailResponse').classList.add('hidden');
    document.getElementById('emailResponse').innerHTML = '';
    document.getElementById('sendBtnText').classList.remove('hidden');
    document.getElementById('loadingSpinner').classList.add('hidden');
    document.getElementById('sendEmailBtn').disabled = false;
}

// Handle form submission
document.getElementById('customEmailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const sendBtn = document.getElementById('sendEmailBtn');
    const sendBtnText = document.getElementById('sendBtnText');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const responseDiv = document.getElementById('emailResponse');
    
    // Show loading state
    sendBtnText.classList.add('hidden');
    loadingSpinner.classList.remove('hidden');
    sendBtn.disabled = true;
    
    // Clear previous response
    responseDiv.classList.add('hidden');
    responseDiv.innerHTML = '';
    
    // Send AJAX request
    fetch('{{ route("admin.applications.send-custom-email", $application) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success response
            responseDiv.classList.remove('hidden');
            responseDiv.innerHTML = `
                <div class="rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">${data.message}</p>
                        </div>
                    </div>
                </div>
            `;
            
            // Reset form after success
            form.reset();
            
            // Auto close modal after 3 seconds
            setTimeout(() => {
                closeCustomEmailModal();
            }, 3000);
            
        } else {
            // Error response
            responseDiv.classList.remove('hidden');
            let errorHtml = `
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">${data.message}</p>
            `;
            
            if (data.errors) {
                errorHtml += `<ul class="list-disc pl-5 text-sm text-red-700 mt-2">`;
                for (const error in data.errors) {
                    errorHtml += `<li>${data.errors[error][0]}</li>`;
                }
                errorHtml += `</ul>`;
            }
            
            errorHtml += `</div></div></div>`;
            responseDiv.innerHTML = errorHtml;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        responseDiv.classList.remove('hidden');
        responseDiv.innerHTML = `
            <div class="rounded-md bg-red-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">An error occurred while sending the message. Please try again.</p>
                    </div>
                </div>
            </div>
        `;
    })
    .finally(() => {
        // Reset button state
        sendBtnText.classList.remove('hidden');
        loadingSpinner.classList.add('hidden');
        sendBtn.disabled = false;
    });
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('customEmailModal').classList.contains('hidden')) {
        closeCustomEmailModal();
    }
});

// Close modal when clicking outside
document.getElementById('customEmailModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCustomEmailModal();
    }
});
</script>



@endsection