@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto py-8 max-w-7xl">
    <!-- Breadcrumb -->
    <!-- <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('job-seeker.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a></li>
            <li><span class="mx-2">›</span></li>
            <li class="text-gray-800 font-medium">Edit Profile</li>
        </ol>
    </nav> -->

    <!-- Success/Error Messages -->
    <!-- @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <ul class="text-red-600 list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif -->

    <!-- Main Layout -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Left Sidebar -->
        <div class="lg:w-64 flex-shrink-0">
            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <!-- Profile Photo -->
                <div class="text-center">
                    <div class="relative w-full flex justify-center">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                 alt="Profile Photo" 
                                 class="w-32 h-32 object-cover border-4 border-white shadow-md mx-auto"
                                 id="profilePhotoPreview">
                        @else
                            <div 
                                class="w-full h-32 mx-auto rounded-md border-2 border-dashed border-gray-300 
                                    flex flex-col items-center justify-center text-center 
                                    text-gray-400 bg-gray-50">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                <span class="text-xs font-medium">Upload Photo</span>
                            </div>
                        @endif

                        <!-- Photo Upload Indicator -->
                        <div id="uploadProgress" class="hidden absolute inset-0 bg-blue-500 bg-opacity-75 rounded-full flex items-center justify-center">
                            <i class="fas fa-spinner fa-spin text-white text-2xl"></i>
                        </div>
                    </div>
                    
                    <!-- <h3 class="mt-3 font-medium text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $jobSeekerProfile->title ?? 'Job Seeker' }}</p> -->
                </div>
                
                <!-- Photo Upload Section -->
                <div class="flex items-center justify-center p-3 space-y-3">
                    <form id="photoUploadForm" action="{{ route('job-seeker.professional-profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="hidden">
                        @csrf
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
                    </form>
                    
                    <!-- Upload -->

                    <button onclick="document.getElementById('profile_photo').click()" 
                            class="flex items-center mr-4 gap-1 text-blue-600 hover:text-blue-800 transition">
                        <i class="fas fa-camera"></i>
                        <span class="text-sm">Upload</span>
                    </button>
                    
                    <!-- Remove -->
                    @if($user->profile_photo)
                    <button onclick="confirmDeletePhoto()"
                            class="flex items-center gap-1 text-red-600 hover:text-red-800 transition">
                        <i class="fas fa-trash"></i>
                        <span class="text-sm">Remove</span>
                    </button>
                    @endif
                    
                    
                </div>
                <div class="text-xs text-gray-400 text-center pt-2 border-t border-gray-100">
                        <p>JPG, PNG or GIF • Max 2MB</p>
                    </div>
            </div>
            
            <!-- Navigation -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200" id="sidebar-nav-container">
                <nav class="p-4">
                    <ul class="space-y-1">
                        <li>
                            <button data-tab="basic-profile" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors {{ $activeTab == 'basic-profile' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="w-1 h-6 rounded-full mr-3 {{ $activeTab == 'basic-profile' ? 'bg-blue-600' : 'bg-transparent' }}"></span>
                                <i class="fas fa-user-circle mr-2"></i>
                                Profile Info
                            </button>
                        </li>
                        <li>
                            <button data-tab="education" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors {{ $activeTab == 'education' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="w-1 h-6 rounded-full mr-3 {{ $activeTab == 'education' ? 'bg-blue-600' : 'bg-transparent' }}"></span>
                                <i class="fas fa-graduation-cap mr-2"></i>
                                Education
                            </button>
                        </li>
                        <li>
                            <button data-tab="skills" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors {{ $activeTab == 'skills' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="w-1 h-6 rounded-full mr-3 {{ $activeTab == 'skills' ? 'bg-blue-600' : 'bg-transparent' }}"></span>
                                <i class="fas fa-tools mr-2"></i>
                                Skills
                            </button>
                        </li>
                        <li>
                            <button data-tab="experience" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors {{ $activeTab == 'experience' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="w-1 h-6 rounded-full mr-3 {{ $activeTab == 'experience' ? 'bg-blue-600' : 'bg-transparent' }}"></span>
                                <i class="fas fa-briefcase mr-2"></i>
                                Experience
                            </button>
                        </li>
                        <li>
                            <button data-tab="projects" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors {{ $activeTab == 'projects' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="w-1 h-6 rounded-full mr-3 {{ $activeTab == 'projects' ? 'bg-blue-600' : 'bg-transparent' }}"></span>
                                <i class="fas fa-project-diagram mr-2"></i>
                                Projects
                            </button>
                        </li>
                        <li>
                            <button data-tab="certifications" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors {{ $activeTab == 'certifications' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="w-1 h-6 rounded-full mr-3 {{ $activeTab == 'certifications' ? 'bg-blue-600' : 'bg-transparent' }}"></span>
                                <i class="fas fa-certificate mr-2"></i>
                                Certifications
                            </button>
                        </li>
                        <li>
                            <button data-tab="social-links" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors {{ $activeTab == 'social-links' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="w-1 h-6 rounded-full mr-3 {{ $activeTab == 'social-links' ? 'bg-blue-600' : 'bg-transparent' }}"></span>
                                <i class="fas fa-share-alt mr-2"></i>
                                Social Links
                            </button>
                        </li>
                        <li>
                            <button data-tab="visibility" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors {{ $activeTab == 'visibility' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="w-1 h-6 rounded-full mr-3 {{ $activeTab == 'visibility' ? 'bg-blue-600' : 'bg-transparent' }}"></span>
                                <i class="fas fa-eye mr-2"></i>
                                Visibility
                            </button>
                        </li>
                        <li>
                            <button data-tab="resume" 
                                    class="w-full text-left px-3 py-2.5 rounded-md flex items-center transition-colors {{ $activeTab == 'resume' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                <span class="w-1 h-6 rounded-full mr-3 {{ $activeTab == 'resume' ? 'bg-blue-600' : 'bg-transparent' }}"></span>
                                <i class="fas fa-file-alt mr-2"></i>
                                Resume
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <!-- Profile Completion -->
            @php
                $totalFields = 11;
                $completedFields = 0;
                if($user->name) $completedFields++;
                if($personalInfo->first_name || $personalInfo->last_name) $completedFields++;
                if($personalInfo->phone || $user->phone) $completedFields++;
                if($personalInfo->address || $user->address) $completedFields++;
                if($jobSeekerProfile->title) $completedFields++;
                if($jobSeekerProfile->summary) $completedFields++;
                if($jobSeekerProfile->experience_level) $completedFields++;
                if($educations->count() > 0) $completedFields++;
                if($skills->count() > 0) $completedFields++;
                if($experiences->count() > 0) $completedFields++;
                if($jobSeekerProfile->resume_file) $completedFields++;
                $completionPercentage = ($completedFields / $totalFields) * 100;
            @endphp
            
            <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Profile Completion</h4>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $completionPercentage }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ round($completionPercentage) }}% Complete • {{ $completedFields }}/{{ $totalFields }} fields</p>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1">
            <!-- Basic Profile Information -->
            <div id="basic-profile" class="section {{ $activeTab == 'basic-profile' ? 'active' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
                        <!-- <p class="text-sm text-gray-600 mt-1">Update your personal and professional information</p> -->
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('job-seeker.professional-profile.complete-update') }}" method="POST">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- Personal Details -->
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Personal Details</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Display Name<span class="text-lg text-red-600">*</span></label>
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address<span class="text-lg text-red-600">*</span></label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                            <input type="text" name="first_name" value="{{ old('first_name', $personalInfo->first_name ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                            <input type="text" name="last_name" value="{{ old('last_name', $personalInfo->last_name ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                            <input type="text" name="phone" value="{{ old('phone', $personalInfo->phone ?? $user->phone) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                            <input type="date" name="date_of_birth" 
                                                value="{{ old('date_of_birth', $personalInfo->date_of_birth ? \Carbon\Carbon::parse($personalInfo->date_of_birth)->format('Y-m-d') : '') }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                            <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Gender</option>
                                                <option value="male" {{ old('gender', $personalInfo->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender', $personalInfo->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                                <option value="other" {{ old('gender', $personalInfo->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Marital Status</label>
                                            <select name="marital_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Status</option>
                                                <option value="single" {{ old('marital_status', $personalInfo->marital_status ?? '') == 'single' ? 'selected' : '' }}>Single</option>
                                                <option value="married" {{ old('marital_status', $personalInfo->marital_status ?? '') == 'married' ? 'selected' : '' }}>Married</option>
                                                <option value="divorced" {{ old('marital_status', $personalInfo->marital_status ?? '') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                                <option value="widowed" {{ old('marital_status', $personalInfo->marital_status ?? '') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                                <option value="separated" {{ old('marital_status', $personalInfo->marital_status ?? '') == 'separated' ? 'selected' : '' }}>Separated</option>
                                                <option value="other" {{ old('marital_status', $personalInfo->marital_status ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Address Information -->
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Address Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                            <input type="text" name="address" value="{{ old('address', $personalInfo->address ?? $user->address) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                            <input type="text" name="city" value="{{ old('city', $personalInfo->city ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">State / Province</label>
                                            <input type="text" name="state" value="{{ old('state', $personalInfo->state ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                            <input type="text" name="country" value="{{ old('country', $personalInfo->country ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">ZIP / Postal Code</label>
                                            <input type="text" name="zip_code" value="{{ old('zip_code', $personalInfo->zip_code ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Professional Information -->
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">Professional Information</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Job Title / Headline</label>
                                            <input type="text" name="title" value="{{ old('title', $jobSeekerProfile->title ?? '') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                   placeholder="e.g., Senior Web Developer">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
                                            <select name="experience_level" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Level</option>
                                                <option value="entry" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                                <option value="junior" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'junior' ? 'selected' : '' }}>Junior</option>
                                                <option value="mid" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'mid' ? 'selected' : '' }}>Mid Level</option>
                                                <option value="senior" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'senior' ? 'selected' : '' }}>Senior</option>
                                                <option value="lead" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'lead' ? 'selected' : '' }}>Lead</option>
                                                <option value="manager" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'manager' ? 'selected' : '' }}>Manager</option>
                                                <option value="director" {{ old('experience_level', $jobSeekerProfile->experience_level ?? '') == 'director' ? 'selected' : '' }}>Director</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Highest Education</label>
                                            <select name="education" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Education</option>
                                                <option value="high_school" {{ old('education', $jobSeekerProfile->education ?? '') == 'high_school' ? 'selected' : '' }}>High School</option>
                                                <option value="diploma" {{ old('education', $jobSeekerProfile->education ?? '') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                                <option value="bachelor" {{ old('education', $jobSeekerProfile->education ?? '') == 'bachelor' ? 'selected' : '' }}>Bachelor's Degree</option>
                                                <option value="master" {{ old('education', $jobSeekerProfile->education ?? '') == 'master' ? 'selected' : '' }}>Master's Degree</option>
                                                <option value="phd" {{ old('education', $jobSeekerProfile->education ?? '') == 'phd' ? 'selected' : '' }}>PhD</option>
                                                <option value="other" {{ old('education', $jobSeekerProfile->education ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Bio / About Me</label>
                                        <textarea name="bio" rows="3"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Tell us about yourself">{{ old('bio', $personalInfo->bio ?? '') }}</textarea>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Professional Summary</label>
                                        <textarea name="summary" rows="4"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                  placeholder="Brief summary of your professional background, skills, and career objectives">{{ old('summary', $jobSeekerProfile->summary ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Save Profile Information
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Education Section -->
            <div id="education" class="section {{ $activeTab == 'education' ? 'active' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Education</h2>
                                <!-- <p class="text-sm text-gray-600 mt-1">Add your educational background</p> -->
                            </div>
                            <button onclick="toggleEducationForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Education
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add/Edit Education Form -->
                        <div id="educationForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4" id="educationFormTitle">Add New Education</h3>
                            <form id="educationFormElement" method="POST" action="{{ route('job-seeker.professional-profile.education.store') }}">
                                @csrf
                                <input type="hidden" id="education_id" name="education_id">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Institution<span class="text-lg text-red-600">*</span></label>
                                        <input type="text" name="institution" id="education_institution" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Degree<span class="text-lg text-red-600">*</span></label>
                                        <input type="text" name="degree" id="education_degree" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date<span class="text-lg text-red-600">*</span></label>
                                        <input type="date" name="start_date" id="education_start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                        <input type="date" name="end_date" id="education_end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_current" id="education_is_current" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleEducationEndDate()">
                                            <span class="ml-2 text-sm text-gray-700">Currently studying here</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleEducationForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" id="educationSubmitBtn" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Education
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Education List -->
                        <div class="space-y-4">
                            @forelse($educations as $education)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $education->degree }}</h3>
                                        <p class="text-gray-600 mt-1">{{ $education->institution }}</p>
                                        <div class="flex items-center mt-2 text-sm text-gray-500">
                                            <i class="fas fa-calendar-alt mr-1.5"></i>
                                            <span>{{ $education->start_date->format('M Y') }} - 
                                            {{ $education->is_current ? 'Present' : ($education->end_date ? $education->end_date->format('M Y') : '') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="editEducation({{ $education->id }}, '{{ addslashes($education->institution) }}', '{{ addslashes($education->degree) }}', '{{ $education->start_date->format('Y-m-d') }}', '{{ $education->end_date ? $education->end_date->format('Y-m-d') : '' }}', {{ $education->is_current ? 'true' : 'false' }})" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form action="{{ route('job-seeker.professional-profile.education.destroy', $education) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this education?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-graduation-cap text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No education added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Education" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            <div id="skills" class="section {{ $activeTab == 'skills' ? 'active' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Skills</h2>
                                <!-- <p class="text-sm text-gray-600 mt-1">Add your professional skills</p> -->
                            </div>
                            <button onclick="toggleSkillForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Skill
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add/Edit Skill Form -->
                        <div id="skillForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4" id="skillFormTitle">Add New Skill</h3>
                            <form id="skillFormElement" method="POST" action="{{ route('job-seeker.professional-profile.skill.store') }}">
                                @csrf
                                <input type="hidden" id="skill_id" name="skill_id">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Skill Name<span class="text-lg text-red-600">*</span></label>
                                        <input type="text" name="name" id="skill_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Proficiency Level</label>
                                        <select name="level" id="skill_level" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Level</option>
                                            <option value="beginner">Beginner</option>
                                            <option value="intermediate">Intermediate</option>
                                            <option value="advanced">Advanced</option>
                                            <option value="expert">Expert</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleSkillForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" id="skillSubmitBtn" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Skill
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Skills List -->
                        <div class="flex flex-wrap gap-2">
                            @forelse($skills as $skill)
                            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-3 py-1.5 rounded-full flex items-center">
                                {{ $skill->name }}
                                @if($skill->level)
                                <span class="ml-1.5 text-xs bg-blue-100 px-1.5 py-0.5 rounded">({{ ucfirst($skill->level) }})</span>
                                @endif
                                <button onclick="editSkill({{ $skill->id }}, '{{ addslashes($skill->name) }}', '{{ $skill->level }}')" 
                                        class="ml-2 text-blue-500 hover:text-blue-700 text-xs">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('job-seeker.professional-profile.skill.destroy', $skill) }}" method="POST" class="ml-1">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-blue-500 hover:text-blue-700 text-xs" onclick="return confirm('Remove this skill?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                            @empty
                            <div class="w-full text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-tools text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No skills added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Skill" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Experience Section -->
            <div id="experience" class="section {{ $activeTab == 'experience' ? 'active' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Work Experience</h2>
                                <!-- <p class="text-sm text-gray-600 mt-1">Add your professional work experience</p> -->
                            </div>
                            <button onclick="toggleExperienceForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Experience
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add/Edit Experience Form -->
                        <div id="experienceForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4" id="experienceFormTitle">Add New Experience</h3>
                            <form id="experienceFormElement" method="POST" action="{{ route('job-seeker.professional-profile.experience.store') }}">
                                @csrf
                                <input type="hidden" id="experience_id" name="experience_id">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Job Title<span class="text-lg text-red-600">*</span></label>
                                        <input type="text" name="job_title" id="experience_job_title" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Company Name<span class="text-lg text-red-600">*</span></label>
                                        <input type="text" name="company_name" id="experience_company_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Employment Type</label>
                                        <select name="employment_type" id="experience_employment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Type</option>
                                            <option value="full-time">Full-time</option>
                                            <option value="part-time">Part-time</option>
                                            <option value="contract">Contract</option>
                                            <option value="freelance">Freelance</option>
                                            <option value="internship">Internship</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                                        <input type="text" name="location" id="experience_location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date<span class="text-lg text-red-600">*</span></label>
                                        <input type="date" name="start_date" id="experience_start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                        <input type="date" name="end_date" id="experience_end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_current" id="experience_is_current" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleExperienceEndDate()">
                                            <span class="ml-2 text-sm text-gray-700">I currently work here</span>
                                        </label>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                        <textarea name="description" id="experience_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleExperienceForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" id="experienceSubmitBtn" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Experience
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Experience List -->
                        <div class="space-y-4">
                            @forelse($experiences as $experience)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $experience->job_title }}</h3>
                                        <p class="text-gray-600 mt-1">{{ $experience->company_name }}</p>
                                        <div class="flex items-center mt-2 space-x-4 text-sm text-gray-500">
                                            @if($experience->employment_type)
                                            <span class="flex items-center">
                                                <i class="fas fa-briefcase mr-1.5"></i>
                                                {{ ucfirst($experience->employment_type) }}
                                            </span>
                                            @endif
                                            @if($experience->location)
                                            <span class="flex items-center">
                                                <i class="fas fa-map-marker-alt mr-1.5"></i>
                                                {{ $experience->location }}
                                            </span>
                                            @endif
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar-alt mr-1.5"></i>
                                                {{ $experience->start_date->format('M Y') }} - 
                                                {{ $experience->is_current ? 'Present' : ($experience->end_date ? $experience->end_date->format('M Y') : '') }}
                                            </span>
                                        </div>
                                        @if($experience->description)
                                        <p class="mt-3 text-gray-700 text-sm">{{ $experience->description }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="editExperience({{ $experience->id }}, '{{ addslashes($experience->job_title) }}', '{{ addslashes($experience->company_name) }}', '{{ $experience->employment_type }}', '{{ $experience->location }}', '{{ $experience->start_date->format('Y-m-d') }}', '{{ $experience->end_date ? $experience->end_date->format('Y-m-d') : '' }}', {{ $experience->is_current ? 'true' : 'false' }}, `{{ addslashes($experience->description) }}`)" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form action="{{ route('job-seeker.professional-profile.experience.destroy', $experience) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this experience?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-briefcase text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No work experience added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Experience" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects Section -->
            <div id="projects" class="section {{ $activeTab == 'projects' ? 'active' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Projects</h2>
                                <!-- <p class="text-sm text-gray-600 mt-1">Showcase your projects and work</p> -->
                            </div>
                            <button onclick="toggleProjectForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Project
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add/Edit Project Form -->
                        <div id="projectForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4" id="projectFormTitle">Add New Project</h3>
                            <form id="projectFormElement" method="POST" action="{{ route('job-seeker.professional-profile.project.store') }}">
                                @csrf
                                <input type="hidden" id="project_id" name="project_id">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Project Title<span class="text-lg text-red-600">*</span></label>
                                        <input type="text" name="title" id="project_title" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                        <input type="text" name="role" id="project_role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date<span class="text-lg text-red-600">*</span></label>
                                        <input type="date" name="start_date" id="project_start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                        <input type="date" name="end_date" id="project_end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_ongoing" id="project_is_ongoing" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleProjectEndDate()">
                                            <span class="ml-2 text-sm text-gray-700">Currently working on this project</span>
                                        </label>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description<span class="text-lg text-red-600">*</span></label>
                                        <textarea name="description" id="project_description" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Project URL (Optional)</label>
                                        <input type="url" name="project_url" id="project_url" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://example.com">
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleProjectForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" id="projectSubmitBtn" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Project
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Projects List -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse($projects as $project)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <h3 class="font-medium text-gray-900">{{ $project->title }}</h3>
                                @if($project->role)
                                <p class="text-sm text-gray-600 mt-1">{{ $project->role }}</p>
                                @endif
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <i class="fas fa-calendar-alt mr-1.5"></i>
                                    <span>{{ $project->start_date->format('M Y') }} - 
                                    {{ $project->is_ongoing ? 'Present' : ($project->end_date ? $project->end_date->format('M Y') : '') }}</span>
                                </div>
                                <p class="mt-3 text-gray-700 text-sm">{{ Str::limit($project->description, 120) }}</p>
                                @if($project->project_url)
                                <a href="{{ $project->project_url }}" target="_blank" class="inline-flex items-center mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    <i class="fas fa-external-link-alt mr-1.5"></i> View Project
                                </a>
                                @endif
                                <div class="mt-4 flex space-x-3">
                                    <button onclick="editProject({{ $project->id }}, '{{ addslashes($project->title) }}', '{{ $project->role }}', '{{ $project->start_date->format('Y-m-d') }}', '{{ $project->end_date ? $project->end_date->format('Y-m-d') : '' }}', {{ $project->is_ongoing ? 'true' : 'false' }}, `{{ addslashes($project->description) }}`, '{{ $project->project_url }}')" 
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Edit
                                    </button>
                                    <form action="{{ route('job-seeker.professional-profile.project.destroy', $project) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this project?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <div class="md:col-span-2 text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-project-diagram text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No projects added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Project" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certifications Section -->
            <div id="certifications" class="section {{ $activeTab == 'certifications' ? 'active' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Certifications</h2>
                                <!-- <p class="text-sm text-gray-600 mt-1">Add your professional certifications</p> -->
                            </div>
                            <button onclick="toggleCertificationForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Certification
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add/Edit Certification Form -->
                        <div id="certificationForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4" id="certificationFormTitle">Add New Certification</h3>
                            <form id="certificationFormElement" method="POST" action="{{ route('job-seeker.professional-profile.certification.store') }}">
                                @csrf
                                <input type="hidden" id="certification_id" name="certification_id">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Certification Name<span class="text-lg text-red-600">*</span></label>
                                        <input type="text" name="name" id="certification_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Issuing Organization<span class="text-lg text-red-600">*</span></label>
                                        <input type="text" name="issuing_organization" id="certification_issuing_organization" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Issue Date<span class="text-lg text-red-600">*</span></label>
                                        <input type="date" name="issue_date" id="certification_issue_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                                        <input type="date" name="expiration_date" id="certification_expiration_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Credential ID (Optional)</label>
                                        <input type="text" name="credential_id" id="certification_credential_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Credential URL (Optional)</label>
                                        <input type="url" name="credential_url" id="certification_credential_url" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://example.com/credential">
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleCertificationForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" id="certificationSubmitBtn" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Certification
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Certifications List -->
                        <div class="space-y-4">
                            @forelse($certifications as $certification)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $certification->name }}</h3>
                                        <p class="text-gray-600 mt-1">{{ $certification->issuing_organization }}</p>
                                        <div class="flex items-center mt-2 text-sm text-gray-500">
                                            <i class="fas fa-calendar-alt mr-1.5"></i>
                                            <span>Issued: {{ $certification->issue_date->format('M Y') }}</span>
                                            @if($certification->expiration_date)
                                            <span class="ml-4">
                                                <i class="fas fa-calendar-times mr-1.5"></i>
                                                Expires: {{ $certification->expiration_date->format('M Y') }}
                                            </span>
                                            @endif
                                        </div>
                                        @if($certification->credential_id)
                                        <p class="mt-2 text-sm text-gray-500">Credential ID: {{ $certification->credential_id }}</p>
                                        @endif
                                        @if($certification->credential_url)
                                        <a href="{{ $certification->credential_url }}" target="_blank" class="inline-flex items-center mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <i class="fas fa-external-link-alt mr-1.5"></i> View Credential
                                        </a>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="editCertification({{ $certification->id }}, '{{ addslashes($certification->name) }}', '{{ addslashes($certification->issuing_organization) }}', '{{ $certification->issue_date->format('Y-m-d') }}', '{{ $certification->expiration_date ? $certification->expiration_date->format('Y-m-d') : '' }}', '{{ $certification->credential_id }}', '{{ $certification->credential_url }}')" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form action="{{ route('job-seeker.professional-profile.certification.destroy', $certification) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this certification?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-certificate text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No certifications added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Certification" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Links Section -->
            <div id="social-links" class="section {{ $activeTab == 'social-links' ? 'active' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Social Links</h2>
                                <!-- <p class="text-sm text-gray-600 mt-1">Add your social media profiles</p> -->
                            </div>
                            <button onclick="toggleSocialLinkForm()" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <i class="fas fa-plus mr-1.5"></i> Add Social Link
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Add/Edit Social Link Form -->
                        <div id="socialLinkForm" class="hidden mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4" id="socialLinkFormTitle">Add New Social Link</h3>
                            <form id="socialLinkFormElement" method="POST" action="{{ route('job-seeker.professional-profile.social-link.store') }}">
                                @csrf
                                <input type="hidden" id="social_link_id" name="social_link_id">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Platform<span class="text-lg text-red-600">*</span></label>
                                        <select name="platform" id="social_link_platform" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select Platform</option>
                                            <option value="linkedin">LinkedIn</option>
                                            <option value="github">GitHub</option>
                                            <option value="twitter">Twitter</option>
                                            <option value="facebook">Facebook</option>
                                            <option value="instagram">Instagram</option>
                                            <option value="website">Portfolio Website</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">URL<span class="text-lg text-red-600">*</span></label>
                                        <input type="url" name="url" id="social_link_url" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://example.com/username">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Username (Optional)</label>
                                        <input type="text" name="username" id="social_link_username" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="username">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_public" id="social_link_is_public" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                                            <span class="ml-2 text-sm text-gray-700">Make this link public on your profile</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="toggleSocialLinkForm()" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        Cancel
                                    </button>
                                    <button type="submit" id="socialLinkSubmitBtn" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Social Link
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Social Links List -->
                        <div class="space-y-4">
                            @forelse($socialLinks as $link)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-4">
                                        <!-- Platform Icon -->
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                            @switch($link->platform)
                                                @case('linkedin') <i class="fab fa-linkedin text-blue-600 text-xl"></i> @break
                                                @case('github') <i class="fab fa-github text-gray-800 text-xl"></i> @break
                                                @case('twitter') <i class="fab fa-twitter text-blue-400 text-xl"></i> @break
                                                @case('facebook') <i class="fab fa-facebook text-blue-600 text-xl"></i> @break
                                                @case('instagram') <i class="fab fa-instagram text-pink-600 text-xl"></i> @break
                                                @case('website') <i class="fas fa-globe text-green-600 text-xl"></i> @break
                                                @default <i class="fas fa-link text-gray-600 text-xl"></i>
                                            @endswitch
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ ucfirst($link->platform) }}</h3>
                                            <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm block truncate max-w-xs">
                                                {{ $link->url }}
                                            </a>
                                            @if($link->username)
                                            <p class="text-xs text-gray-500 mt-0.5">Username: {{ $link->username }}</p>
                                            @endif
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $link->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} mt-1">
                                                {{ $link->is_public ? 'Public' : 'Private' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-3">
                                        <button onclick="editSocialLink({{ $link->id }}, '{{ $link->platform }}', '{{ $link->url }}', '{{ $link->username }}', {{ $link->is_public ? 'true' : 'false' }})" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Edit
                                        </button>
                                        <form action="{{ route('job-seeker.professional-profile.social-link.destroy', $link) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Delete this social link?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
                                <i class="fas fa-share-alt text-gray-400 text-3xl mb-3"></i>
                                <p class="text-gray-500">No social links added yet</p>
                                <p class="text-gray-400 text-sm mt-1">Click "Add Social Link" to get started</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visibility Settings Section -->
            <div id="visibility" class="section {{ $activeTab == 'visibility' ? 'active' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Visibility Settings</h2>
                                <!-- <p class="text-sm text-gray-600 mt-1">Control your profile visibility and privacy</p> -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('job-seeker.professional-profile.visibility.update') }}" method="POST">
                            @csrf
                            <div class="space-y-6">
                                <!-- Profile Visibility -->
                                <div class="bg-gray-50 rounded-lg p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">Profile Visibility</h3>
                                            <p class="text-sm text-gray-600 mt-1">Control who can see your profile</p>
                                        </div>
                                        <select name="profile_visibility" class="w-48 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                            <option value="public" {{ ($visibilitySettings->profile_visibility ?? '') == 'public' ? 'selected' : '' }}>Public</option>
                                            <option value="private" {{ ($visibilitySettings->profile_visibility ?? '') == 'private' ? 'selected' : '' }}>Private</option>
                                            <option value="recruiters_only" {{ ($visibilitySettings->profile_visibility ?? '') == 'recruiters_only' ? 'selected' : '' }}>Recruiters Only</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Contact Information -->
                                <div class="bg-gray-50 rounded-lg p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">Contact Information</h3>
                                            <p class="text-sm text-gray-600 mt-1">Show your contact details on profile</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="show_contact_info" value="1" class="sr-only peer" {{ ($visibilitySettings->show_contact_info ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Show Resume -->
                                <div class="bg-gray-50 rounded-lg p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">Show Resume</h3>
                                            <p class="text-sm text-gray-600 mt-1">Allow recruiters to download your resume</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="show_resume" value="1" class="sr-only peer" {{ ($visibilitySettings->show_resume ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Email Notifications -->
                                <div class="bg-gray-50 rounded-lg p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">Email Notifications</h3>
                                            <p class="text-sm text-gray-600 mt-1">Receive job alerts and updates</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="email_notifications" value="1" class="sr-only peer" {{ ($visibilitySettings->email_notifications ?? false) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Save Visibility Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Resume Section -->
            <div id="resume" class="section {{ $activeTab == 'resume' ? 'active' : 'hidden' }}">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Resume</h2>
                                <!-- <p class="text-sm text-gray-600 mt-1">Upload and manage your resume</p> -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Current Resume -->
                        @if($jobSeekerProfile->resume_file)
                        <div class="mb-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">Current Resume</h3>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-file-pdf text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">Your Resume</h4>
                                        <p class="text-sm text-gray-600">Uploaded on {{ \Carbon\Carbon::parse($jobSeekerProfile->updated_at)->format('M d, Y') }}</p>
                                        <div class="mt-2 flex space-x-3">
                                            <a href="{{ asset('storage/' . $jobSeekerProfile->resume_file) }}" 
                                               target="_blank" 
                                               class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium mr-2">
                                                <i class="fas fa-eye mr-1"></i> View Resume
                                            </a>
                                            <a href="{{ asset('storage/' . $jobSeekerProfile->resume_file) }}" 
                                               download 
                                               class="inline-flex items-center text-green-600 hover:text-green-800 text-sm font-medium mr-2">
                                                <i class="fas fa-download mr-1"></i> Download
                                            </a>
                                             <form action="{{ route('job-seeker.professional-profile.resume.delete') }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        onclick="return confirm('Are you sure you want to delete your resume?')"
                                                        class="text-red-600 hover:text-red-800 text-sm font-medium ml-2">
                                                    <i class="fas fa-trash "></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        @endif
                        
                        <!-- Upload Resume Form -->
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-sm font-medium text-gray-900 mb-4">
                                @if($jobSeekerProfile->resume_file)
                                Upload New Resume
                                @else
                                Upload Resume
                                @endif
                            </h3>
                            
                            <form action="{{ route('job-seeker.professional-profile.resume.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="space-y-4">
                                    <div>
                                        <!-- <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Resume File *
                                        </label> -->
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="resume_file" class="mx-auto relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500 ">
                                                        <span>Upload a file</span>
                                                        <input id="resume_file" name="resume_file" type="file" class="sr-only" accept=".pdf,.doc,.docx">
                                                    </label>
                                                    <!-- <p class="pl-1">or drag and drop</p> -->
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    PDF, DOC, DOCX up to 5MB
                                                </p>
                                                @if($errors->has('resume_file'))
                                                    <p class="text-red-500 text-xs mt-1">{{ $errors->first('resume_file') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex justify-end">
                                    <button type="submit" 
                                            class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        @if($jobSeekerProfile->resume_file)
                                        Update Resume
                                        @else
                                        Upload Resume
                                        @endif
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Tips -->
                        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-lightbulb text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-yellow-800">Tips for a great resume</h4>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Keep it to 1-2 pages maximum</li>
                                            <li>Include relevant keywords from job descriptions</li>
                                            <li>Quantify your achievements with numbers</li>
                                            <li>Use a clean, professional format</li>
                                            <li>Proofread for spelling and grammar errors</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deletePhotoForm" action="{{ route('job-seeker.professional-profile.photo.delete') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
// Tab Management
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listeners to all tab buttons
    document.querySelectorAll('#sidebar-nav-container button[data-tab]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const tabId = this.getAttribute('data-tab');
            showTab(tabId);
        });
    });

    // Show the active tab on page load
    const activeTab = '{{ $activeTab }}';
    if (activeTab) {
        showTab(activeTab, false); // Don't update URL
    }
});

function showTab(tabId, updateURL = true) {
    // Hide all sections
    document.querySelectorAll('.section').forEach(section => {
        section.classList.add('hidden');
        section.classList.remove('active');
    });
    
    // Show selected section
    const section = document.getElementById(tabId);
    if (section) {
        section.classList.remove('hidden');
        section.classList.add('active');
        
        // Scroll to top of section
        // section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    // Update sidebar active state
    document.querySelectorAll('#sidebar-nav-container button[data-tab]').forEach(button => {
        const buttonTabId = button.getAttribute('data-tab');
        if (buttonTabId === tabId) {
            button.classList.remove('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
            button.classList.add('bg-blue-50', 'text-blue-700', 'font-medium');
            button.querySelector('span').classList.remove('bg-transparent');
            button.querySelector('span').classList.add('bg-blue-600');
        } else {
            button.classList.remove('bg-blue-50', 'text-blue-700', 'font-medium');
            button.classList.add('text-gray-600', 'hover:bg-gray-50', 'hover:text-gray-900');
            button.querySelector('span').classList.remove('bg-blue-600');
            button.querySelector('span').classList.add('bg-transparent');
        }
    });
    
    // Update URL without reloading page
    if (updateURL) {
        const url = new URL(window.location);
        url.searchParams.set('tab', tabId);
        window.history.pushState({}, '', url);
    }
}

// Handle browser back/forward buttons
window.addEventListener('popstate', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    if (tabParam) {
        showTab(tabParam, false);
    }
});

// Form Toggle Functions
function toggleEducationForm() {
    const form = document.getElementById('educationForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleSkillForm() {
    const form = document.getElementById('skillForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleExperienceForm() {
    const form = document.getElementById('experienceForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleProjectForm() {
    const form = document.getElementById('projectForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleCertificationForm() {
    const form = document.getElementById('certificationForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

function toggleSocialLinkForm() {
    const form = document.getElementById('socialLinkForm');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

// Date Toggle Functions
function toggleEducationEndDate() {
    const checkbox = document.getElementById('education_is_current');
    const endDate = document.getElementById('education_end_date');
    endDate.disabled = checkbox.checked;
    if (checkbox.checked) {
        endDate.value = '';
    }
}

function toggleExperienceEndDate() {
    const checkbox = document.getElementById('experience_is_current');
    const endDate = document.getElementById('experience_end_date');
    endDate.disabled = checkbox.checked;
    if (checkbox.checked) {
        endDate.value = '';
    }
}

function toggleProjectEndDate() {
    const checkbox = document.getElementById('project_is_ongoing');
    const endDate = document.getElementById('project_end_date');
    endDate.disabled = checkbox.checked;
    if (checkbox.checked) {
        endDate.value = '';
    }
}

// Edit Functions
function editEducation(id, institution, degree, startDate, endDate, isCurrent) {
    // Set form values
    document.getElementById('education_id').value = id;
    document.getElementById('education_institution').value = institution;
    document.getElementById('education_degree').value = degree;
    document.getElementById('education_start_date').value = startDate;
    document.getElementById('education_end_date').value = endDate || '';
    document.getElementById('education_is_current').checked = isCurrent;
    
    // Update form title and button
    document.getElementById('educationFormTitle').textContent = 'Edit Education';
    document.getElementById('educationSubmitBtn').textContent = 'Update Education';
    document.getElementById('educationSubmitBtn').className = document.getElementById('educationSubmitBtn').className.replace('bg-blue-600', 'bg-green-600').replace('hover:bg-blue-700', 'hover:bg-green-700');
    
    // Update form action
    document.getElementById('educationFormElement').action = `/job-seeker/profile/education/${id}`;
    
    // Add method spoofing for PUT
    const form = document.getElementById('educationFormElement');
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    } else {
        methodInput.value = 'PUT';
    }
    
    // Toggle end date
    toggleEducationEndDate();
    
    // Show form
    document.getElementById('educationForm').classList.remove('hidden');
    document.getElementById('educationForm').scrollIntoView({ behavior: 'smooth' });
}

function editSkill(id, name, level) {
    // Set form values
    document.getElementById('skill_id').value = id;
    document.getElementById('skill_name').value = name;
    document.getElementById('skill_level').value = level || '';
    
    // Update form title and button
    document.getElementById('skillFormTitle').textContent = 'Edit Skill';
    document.getElementById('skillSubmitBtn').textContent = 'Update Skill';
    document.getElementById('skillSubmitBtn').className = document.getElementById('skillSubmitBtn').className.replace('bg-blue-600', 'bg-green-600').replace('hover:bg-blue-700', 'hover:bg-green-700');
    
    // Update form action
    document.getElementById('skillFormElement').action = `/job-seeker/profile/skill/${id}`;
    
    // Add method spoofing for PUT
    const form = document.getElementById('skillFormElement');
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    } else {
        methodInput.value = 'PUT';
    }
    
    // Show form
    document.getElementById('skillForm').classList.remove('hidden');
    document.getElementById('skillForm').scrollIntoView({ behavior: 'smooth' });
}

function editExperience(id, jobTitle, companyName, employmentType, location, startDate, endDate, isCurrent, description) {
    // Set form values
    document.getElementById('experience_id').value = id;
    document.getElementById('experience_job_title').value = jobTitle;
    document.getElementById('experience_company_name').value = companyName;
    document.getElementById('experience_employment_type').value = employmentType || '';
    document.getElementById('experience_location').value = location || '';
    document.getElementById('experience_start_date').value = startDate;
    document.getElementById('experience_end_date').value = endDate || '';
    document.getElementById('experience_is_current').checked = isCurrent;
    document.getElementById('experience_description').value = description || '';
    
    // Update form title and button
    document.getElementById('experienceFormTitle').textContent = 'Edit Experience';
    document.getElementById('experienceSubmitBtn').textContent = 'Update Experience';
    document.getElementById('experienceSubmitBtn').className = document.getElementById('experienceSubmitBtn').className.replace('bg-blue-600', 'bg-green-600').replace('hover:bg-blue-700', 'hover:bg-green-700');
    
    // Update form action
    document.getElementById('experienceFormElement').action = `/job-seeker/profile/experience/${id}`;
    
    // Add method spoofing for PUT
    const form = document.getElementById('experienceFormElement');
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    } else {
        methodInput.value = 'PUT';
    }
    
    // Toggle end date
    toggleExperienceEndDate();
    
    // Show form
    document.getElementById('experienceForm').classList.remove('hidden');
    document.getElementById('experienceForm').scrollIntoView({ behavior: 'smooth' });
}

function editProject(id, title, role, startDate, endDate, isOngoing, description, projectUrl) {
    // Set form values
    document.getElementById('project_id').value = id;
    document.getElementById('project_title').value = title;
    document.getElementById('project_role').value = role || '';
    document.getElementById('project_start_date').value = startDate;
    document.getElementById('project_end_date').value = endDate || '';
    document.getElementById('project_is_ongoing').checked = isOngoing;
    document.getElementById('project_description').value = description || '';
    document.getElementById('project_url').value = projectUrl || '';
    
    // Update form title and button
    document.getElementById('projectFormTitle').textContent = 'Edit Project';
    document.getElementById('projectSubmitBtn').textContent = 'Update Project';
    document.getElementById('projectSubmitBtn').className = document.getElementById('projectSubmitBtn').className.replace('bg-blue-600', 'bg-green-600').replace('hover:bg-blue-700', 'hover:bg-green-700');
    
    // Update form action
    document.getElementById('projectFormElement').action = `/job-seeker/profile/project/${id}`;
    
    // Add method spoofing for PUT
    const form = document.getElementById('projectFormElement');
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    } else {
        methodInput.value = 'PUT';
    }
    
    // Toggle end date
    toggleProjectEndDate();
    
    // Show form
    document.getElementById('projectForm').classList.remove('hidden');
    document.getElementById('projectForm').scrollIntoView({ behavior: 'smooth' });
}

function editCertification(id, name, issuingOrganization, issueDate, expirationDate, credentialId, credentialUrl) {
    // Set form values
    document.getElementById('certification_id').value = id;
    document.getElementById('certification_name').value = name;
    document.getElementById('certification_issuing_organization').value = issuingOrganization;
    document.getElementById('certification_issue_date').value = issueDate;
    document.getElementById('certification_expiration_date').value = expirationDate || '';
    document.getElementById('certification_credential_id').value = credentialId || '';
    document.getElementById('certification_credential_url').value = credentialUrl || '';
    
    // Update form title and button
    document.getElementById('certificationFormTitle').textContent = 'Edit Certification';
    document.getElementById('certificationSubmitBtn').textContent = 'Update Certification';
    document.getElementById('certificationSubmitBtn').className = document.getElementById('certificationSubmitBtn').className.replace('bg-blue-600', 'bg-green-600').replace('hover:bg-blue-700', 'hover:bg-green-700');
    
    // Update form action
    document.getElementById('certificationFormElement').action = `/job-seeker/profile/certification/${id}`;
    
    // Add method spoofing for PUT
    const form = document.getElementById('certificationFormElement');
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    } else {
        methodInput.value = 'PUT';
    }
    
    // Show form
    document.getElementById('certificationForm').classList.remove('hidden');
    document.getElementById('certificationForm').scrollIntoView({ behavior: 'smooth' });
}

function editSocialLink(id, platform, url, username, isPublic) {
    // Set form values
    document.getElementById('social_link_id').value = id;
    document.getElementById('social_link_platform').value = platform;
    document.getElementById('social_link_url').value = url;
    document.getElementById('social_link_username').value = username || '';
    document.getElementById('social_link_is_public').checked = isPublic;
    
    // Update form title and button
    document.getElementById('socialLinkFormTitle').textContent = 'Edit Social Link';
    document.getElementById('socialLinkSubmitBtn').textContent = 'Update Social Link';
    document.getElementById('socialLinkSubmitBtn').className = document.getElementById('socialLinkSubmitBtn').className.replace('bg-blue-600', 'bg-green-600').replace('hover:bg-blue-700', 'hover:bg-green-700');
    
    // Update form action
    document.getElementById('socialLinkFormElement').action = `/job-seeker/profile/social-link/${id}`;
    
    // Add method spoofing for PUT
    const form = document.getElementById('socialLinkFormElement');
    let methodInput = form.querySelector('input[name="_method"]');
    if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
    } else {
        methodInput.value = 'PUT';
    }
    
    // Show form
    document.getElementById('socialLinkForm').classList.remove('hidden');
    document.getElementById('socialLinkForm').scrollIntoView({ behavior: 'smooth' });
}

// Reset forms to create mode when toggled
document.addEventListener('DOMContentLoaded', function() {
    // Education form reset
    document.getElementById('educationFormElement').addEventListener('reset', function() {
        document.getElementById('educationFormTitle').textContent = 'Add New Education';
        document.getElementById('educationSubmitBtn').textContent = 'Add Education';
        document.getElementById('educationSubmitBtn').className = document.getElementById('educationSubmitBtn').className.replace('bg-green-600', 'bg-blue-600').replace('hover:bg-green-700', 'hover:bg-blue-700');
        document.getElementById('educationFormElement').action = '{{ route('job-seeker.professional-profile.education.store') }}';
        
        const methodInput = document.getElementById('educationFormElement').querySelector('input[name="_method"]');
        if (methodInput) {
            methodInput.remove();
        }
    });
    
    // Similar for other forms
    const forms = ['skillFormElement', 'experienceFormElement', 'projectFormElement', 'certificationFormElement', 'socialLinkFormElement'];
    
    forms.forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('reset', function() {
                const formTitle = document.getElementById(formId.replace('Element', 'Title'));
                const submitBtn = document.getElementById(formId.replace('Element', 'SubmitBtn'));
                
                if (formTitle && submitBtn) {
                    formTitle.textContent = formTitle.textContent.replace('Edit', 'Add New');
                    submitBtn.textContent = submitBtn.textContent.replace('Update', 'Add');
                    submitBtn.className = submitBtn.className.replace('bg-green-600', 'bg-blue-600').replace('hover:bg-green-700', 'hover:bg-blue-700');
                }
                
                // Reset action to store route
                const baseRoute = formId.replace('FormElement', '').replace(/([A-Z])/g, '-$1').toLowerCase();
                form.action = `/job-seeker/profile/${baseRoute}`;
                
                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) {
                    methodInput.remove();
                }
            });
        }
    });
});

// Photo Upload
document.getElementById('profile_photo').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        // Show upload progress
        const progress = document.getElementById('uploadProgress');
        progress.classList.remove('hidden');
        
        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profilePhotoPreview');
            if (preview) {
                preview.src = e.target.result;
            } else {
                // Create preview if it doesn't exist (for default avatar)
                const profileSection = document.querySelector('.text-center .relative');
                if (profileSection) {
                    const img = document.createElement('img');
                    img.id = 'profilePhotoPreview';
                    img.src = e.target.result;
                    img.alt = 'Profile Photo';
                    img.className = 'w-32 h-32 rounded-full object-cover border-4 border-white shadow-md mx-auto';
                    profileSection.querySelector('div, img').replaceWith(img);
                }
            }
        }
        reader.readAsDataURL(this.files[0]);
        
        // Submit form
        document.getElementById('photoUploadForm').submit();
    }
});

function confirmDeletePhoto() {
    if (confirm('Are you sure you want to delete your profile photo?')) {
        document.getElementById('deletePhotoForm').submit();
    }
}

// Initialize date toggles
document.addEventListener('DOMContentLoaded', function() {
    toggleEducationEndDate();
    toggleExperienceEndDate();
    toggleProjectEndDate();
});
</script>

<style>
.section {
    display: block;
    animation: fadeIn 0.3s ease-in-out;
}

.section.hidden {
    display: none;
}

.section.active {
    display: block;
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

/* Smooth transitions */
button, input, select, textarea {
    transition: all 0.2s ease-in-out;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}
</style>
@endsection