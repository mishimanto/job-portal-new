@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="{{ route('job-seeker.dashboard') }}" class="hover:text-blue-600">Dashboard</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-800 font-medium">Edit Profile</li>
        </ol>
    </nav>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Left Sidebar - Navigation -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Edit Profile</h2>
                <ul class="space-y-2">
                    <li><a href="#personal" class="flex items-center text-blue-600 hover:text-blue-800">
                        <span class="mr-2">•</span> Personal Information
                    </a></li>
                    <li><a href="#education" class="flex items-center text-gray-600 hover:text-gray-800">
                        <span class="mr-2">•</span> Education
                    </a></li>
                    <li><a href="#skills" class="flex items-center text-gray-600 hover:text-gray-800">
                        <span class="mr-2">•</span> Skills
                    </a></li>
                    <li><a href="#experience" class="flex items-center text-gray-600 hover:text-gray-800">
                        <span class="mr-2">•</span> Experience
                    </a></li>
                    <li><a href="#projects" class="flex items-center text-gray-600 hover:text-gray-800">
                        <span class="mr-2">•</span> Projects
                    </a></li>
                    <li><a href="#certifications" class="flex items-center text-gray-600 hover:text-gray-800">
                        <span class="mr-2">•</span> Certifications
                    </a></li>
                    <li><a href="#social-links" class="flex items-center text-gray-600 hover:text-gray-800">
                        <span class="mr-2">•</span> Social Links
                    </a></li>
                    <li><a href="#visibility" class="flex items-center text-gray-600 hover:text-gray-800">
                        <span class="mr-2">•</span> Visibility
                    </a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:w-3/4">
            <!-- Personal Information -->
            <div id="personal" class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
                <form action="{{ route('job-seeker.profile.personal-info.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $personalInfo->first_name ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $personalInfo->last_name ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $personalInfo->phone ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $personalInfo->date_of_birth ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="address" value="{{ old('address', $personalInfo->address ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" name="city" value="{{ old('city', $personalInfo->city ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <input type="text" name="country" value="{{ old('country', $personalInfo->country ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                            <textarea name="bio" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $personalInfo->bio ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Personal Information
                        </button>
                    </div>
                </form>
            </div>

            <!-- Education -->
            <div id="education" class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Education</h2>
                    <button onclick="toggleEducationForm()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Add Education
                    </button>
                </div>

                <!-- Add Education Form (Initially Hidden) -->
                <div id="educationForm" class="hidden mb-6">
                    <form action="{{ route('job-seeker.profile.education.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Institution</label>
                                <input type="text" name="institution" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Degree</label>
                                <input type="text" name="degree" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_current" class="mr-2">
                                    <span class="text-sm text-gray-700">Currently studying here</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Add Education</button>
                            <button type="button" onclick="toggleEducationForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Edit Education Form (Hidden by default) -->
                <div id="editEducationForm" class="hidden mb-6">
                    <form id="editEducationFormElement" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Institution</label>
                                <input type="text" name="institution" required id="edit_institution" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Degree</label>
                                <input type="text" name="degree" required id="edit_degree" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                <input type="date" name="start_date" required id="edit_start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <input type="date" name="end_date" id="edit_end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_current" id="edit_is_current" class="mr-2">
                                    <span class="text-sm text-gray-700">Currently studying here</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update Education</button>
                            <button type="button" onclick="toggleEditEducationForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Education List -->
                <div class="space-y-4">
                    @foreach($educations as $education)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-semibold">{{ $education->degree }}</h3>
                                <p class="text-gray-600">{{ $education->institution }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $education->start_date->format('M Y') }} - 
                                    {{ $education->is_current ? 'Present' : ($education->end_date ? $education->end_date->format('M Y') : '') }}
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="editEducation({{ $education->id }}, '{{ $education->institution }}', '{{ $education->degree }}', '{{ $education->start_date->format('Y-m-d') }}', '{{ $education->end_date ? $education->end_date->format('Y-m-d') : '' }}', {{ $education->is_current ? 'true' : 'false' }})" class="text-blue-600 hover:text-blue-800">Edit</button>
                                <form action="{{ route('job-seeker.profile.education.destroy', $education) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this education?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Skills -->
            <div id="skills" class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Skills</h2>
                    <button onclick="toggleSkillForm()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Add Skill
                    </button>
                </div>

                <!-- Add Skill Form -->
                <div id="skillForm" class="hidden mb-6">
                    <form action="{{ route('job-seeker.profile.skill.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Skill Name</label>
                                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                                <select name="level" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    <option value="">Select Level</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                    <option value="expert">Expert</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Add Skill</button>
                            <button type="button" onclick="toggleSkillForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Skills List -->
                <div class="flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full flex items-center">
                        {{ $skill->name }}
                        @if($skill->level)
                        <span class="ml-1 text-xs">({{ ucfirst($skill->level) }})</span>
                        @endif
                        <form action="{{ route('job-seeker.profile.skill.destroy', $skill) }}" method="POST" class="ml-2">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs" onclick="return confirm('Are you sure you want to delete this skill?')">×</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Experience -->
            <div id="experience" class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Experience</h2>
                    <button onclick="toggleExperienceForm()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Add Experience
                    </button>
                </div>

                <!-- Add Experience Form (Initially Hidden) -->
                <div id="experienceForm" class="hidden mb-6">
                    <form action="{{ route('job-seeker.profile.experience.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input type="text" name="job_title" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input type="text" name="company_name" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Employment Type</label>
                                <select name="employment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md">
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
                                <input type="text" name="location" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_current" class="mr-2">
                                    <span class="text-sm text-gray-700">I currently work here</span>
                                </label>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Add Experience</button>
                            <button type="button" onclick="toggleExperienceForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Edit Experience Form (Hidden by default) -->
                <div id="editExperienceForm" class="hidden mb-6">
                    <form id="editExperienceFormElement" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input type="text" name="job_title" required id="edit_job_title" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input type="text" name="company_name" required id="edit_company_name" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Employment Type</label>
                                <select name="employment_type" id="edit_employment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md">
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
                                <input type="text" name="location" id="edit_location" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                <input type="date" name="start_date" required id="edit_experience_start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <input type="date" name="end_date" id="edit_experience_end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_current" id="edit_experience_is_current" class="mr-2">
                                    <span class="text-sm text-gray-700">I currently work here</span>
                                </label>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3" id="edit_experience_description" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update Experience</button>
                            <button type="button" onclick="toggleEditExperienceForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Experience List -->
                <div class="space-y-4">
                    @foreach($experiences as $experience)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-semibold">{{ $experience->job_title }}</h3>
                                <p class="text-gray-600">{{ $experience->company_name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $experience->employment_type ? ucfirst($experience->employment_type) : '' }}
                                    @if($experience->location)
                                    • {{ $experience->location }}
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $experience->start_date->format('M Y') }} - 
                                    {{ $experience->is_current ? 'Present' : ($experience->end_date ? $experience->end_date->format('M Y') : '') }}
                                </p>
                                @if($experience->description)
                                <p class="mt-2 text-gray-700">{{ $experience->description }}</p>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="editExperience({{ $experience->id }}, '{{ $experience->job_title }}', '{{ $experience->company_name }}', '{{ $experience->employment_type }}', '{{ $experience->location }}', '{{ $experience->start_date->format('Y-m-d') }}', '{{ $experience->end_date ? $experience->end_date->format('Y-m-d') : '' }}', {{ $experience->is_current ? 'true' : 'false' }}, `{{ $experience->description }}`)" class="text-blue-600 hover:text-blue-800">Edit</button>
                                <form action="{{ route('job-seeker.profile.experience.destroy', $experience) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this experience?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($experiences->isEmpty())
                    <div class="text-center py-8 border border-gray-300 border-dashed rounded-lg">
                        <p class="text-gray-500">No experience added yet. Click "Add Experience" to add your first work experience.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Projects -->
            <div id="projects" class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Projects</h2>
                    <button onclick="toggleProjectForm()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Add Project
                    </button>
                </div>

                <!-- Add Project Form (Initially Hidden) -->
                <div id="projectForm" class="hidden mb-6">
                    <form action="{{ route('job-seeker.profile.project.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Project Title</label>
                                <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <input type="text" name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                <input type="date" name="start_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_ongoing" class="mr-2">
                                    <span class="text-sm text-gray-700">Currently working on this project</span>
                                </label>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Project URL (Optional)</label>
                                <input type="url" name="project_url" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="https://example.com">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Add Project</button>
                            <button type="button" onclick="toggleProjectForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Edit Project Form (Hidden by default) -->
                <div id="editProjectForm" class="hidden mb-6">
                    <form id="editProjectFormElement" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Project Title</label>
                                <input type="text" name="title" required id="edit_project_title" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <input type="text" name="role" id="edit_project_role" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                <input type="date" name="start_date" required id="edit_project_start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <input type="date" name="end_date" id="edit_project_end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_ongoing" id="edit_project_is_ongoing" class="mr-2">
                                    <span class="text-sm text-gray-700">Currently working on this project</span>
                                </label>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <textarea name="description" rows="3" required id="edit_project_description" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Project URL (Optional)</label>
                                <input type="url" name="project_url" id="edit_project_url" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="https://example.com">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update Project</button>
                            <button type="button" onclick="toggleEditProjectForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Projects List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($projects as $project)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="font-semibold">{{ $project->title }}</h3>
                        @if($project->role)
                        <p class="text-sm text-gray-600 mt-1">Role: {{ $project->role }}</p>
                        @endif
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $project->start_date->format('M Y') }} - 
                            {{ $project->is_ongoing ? 'Present' : ($project->end_date ? $project->end_date->format('M Y') : '') }}
                        </p>
                        <p class="text-gray-700 mt-2 text-sm">{{ Str::limit($project->description, 100) }}</p>
                        @if($project->project_url)
                        <a href="{{ $project->project_url }}" target="_blank" class="text-blue-600 text-sm mt-2 inline-block">View Project →</a>
                        @endif
                        <div class="mt-3 flex space-x-2">
                            <button onclick="editProject({{ $project->id }}, '{{ $project->title }}', '{{ $project->role }}', '{{ $project->start_date->format('Y-m-d') }}', '{{ $project->end_date ? $project->end_date->format('Y-m-d') : '' }}', {{ $project->is_ongoing ? 'true' : 'false' }}, `{{ $project->description }}`, '{{ $project->project_url }}')" class="text-blue-600 hover:text-blue-800 text-sm">Edit</button>
                            <form action="{{ route('job-seeker.profile.project.destroy', $project) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($projects->isEmpty())
                    <div class="md:col-span-2 text-center py-8 border border-gray-300 border-dashed rounded-lg">
                        <p class="text-gray-500">No projects added yet. Click "Add Project" to showcase your work.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Certifications -->
            <div id="certifications" class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Certifications</h2>
                    <button onclick="toggleCertificationForm()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Add Certification
                    </button>
                </div>

                <!-- Add Certification Form (Initially Hidden) -->
                <div id="certificationForm" class="hidden mb-6">
                    <form action="{{ route('job-seeker.profile.certification.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Certification Name</label>
                                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Issuing Organization</label>
                                <input type="text" name="issuing_organization" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Issue Date</label>
                                <input type="date" name="issue_date" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                                <input type="date" name="expiration_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Credential ID (Optional)</label>
                                <input type="text" name="credential_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Credential URL (Optional)</label>
                                <input type="url" name="credential_url" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="https://example.com/credential">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Add Certification</button>
                            <button type="button" onclick="toggleCertificationForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Edit Certification Form (Hidden by default) -->
                <div id="editCertificationForm" class="hidden mb-6">
                    <form id="editCertificationFormElement" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Certification Name</label>
                                <input type="text" name="name" required id="edit_certification_name" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Issuing Organization</label>
                                <input type="text" name="issuing_organization" required id="edit_issuing_organization" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Issue Date</label>
                                <input type="date" name="issue_date" required id="edit_issue_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiration Date</label>
                                <input type="date" name="expiration_date" id="edit_expiration_date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Credential ID (Optional)</label>
                                <input type="text" name="credential_id" id="edit_credential_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Credential URL (Optional)</label>
                                <input type="url" name="credential_url" id="edit_credential_url" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="https://example.com/credential">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update Certification</button>
                            <button type="button" onclick="toggleEditCertificationForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- Certifications List -->
                <div class="space-y-4">
                    @foreach($certifications as $certification)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="font-semibold">{{ $certification->name }}</h3>
                                <p class="text-gray-600">{{ $certification->issuing_organization }}</p>
                                <p class="text-sm text-gray-500">
                                    Issued: {{ $certification->issue_date->format('M Y') }}
                                    @if($certification->expiration_date)
                                    • Expires: {{ $certification->expiration_date->format('M Y') }}
                                    @endif
                                </p>
                                @if($certification->credential_id)
                                <p class="text-sm text-gray-500">Credential ID: {{ $certification->credential_id }}</p>
                                @endif
                                @if($certification->credential_url)
                                <a href="{{ $certification->credential_url }}" target="_blank" class="text-blue-600 text-sm mt-1 inline-block">View Credential →</a>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="editCertification({{ $certification->id }}, '{{ $certification->name }}', '{{ $certification->issuing_organization }}', '{{ $certification->issue_date->format('Y-m-d') }}', '{{ $certification->expiration_date ? $certification->expiration_date->format('Y-m-d') : '' }}', '{{ $certification->credential_id }}', '{{ $certification->credential_url }}')" class="text-blue-600 hover:text-blue-800">Edit</button>
                                <form action="{{ route('job-seeker.profile.certification.destroy', $certification) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this certification?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($certifications->isEmpty())
                    <div class="text-center py-8 border border-gray-300 border-dashed rounded-lg">
                        <p class="text-gray-500">No certifications added yet. Click "Add Certification" to add your first certification.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Social Links -->
            <!-- Social Links -->
<div id="social-links" class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Social Links</h2>
        <button type="button" onclick="toggleSocialLinkForm()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
            Add Social Link
        </button>
    </div>

    <!-- Add Social Link Form (Initially Hidden) -->
    <div id="socialLinkForm" class="hidden mb-6">
        <form action="{{ route('job-seeker.profile.social-link.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Platform</label>
                    <select name="platform" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                    <input type="url" name="url" required class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="https://example.com/username">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username (Optional)</label>
                    <input type="text" name="username" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="username">
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_public" value="1" class="mr-2" checked>
                        <span class="text-sm text-gray-700">Make this link public on your profile</span>
                    </label>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Add Social Link</button>
                <button type="button" onclick="toggleSocialLinkForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Edit Social Link Form (Hidden by default) -->
    <div id="editSocialLinkForm" class="hidden mb-6">
        <form id="editSocialLinkFormElement" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Platform</label>
                    <select name="platform" required id="edit_social_platform" class="w-full px-3 py-2 border border-gray-300 rounded-md">
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                    <input type="url" name="url" required id="edit_social_url" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username (Optional)</label>
                    <input type="text" name="username" id="edit_social_username" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_public" value="1" id="edit_social_is_public" class="mr-2">
                        <span class="text-sm text-gray-700">Make this link public on your profile</span>
                    </label>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Update Social Link</button>
                <button type="button" onclick="toggleEditSocialLinkForm()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md ml-2">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Social Links List -->
    <div class="space-y-4">
        @foreach($socialLinks as $link)
        <div class="border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <!-- Platform Icon -->
                    @switch($link->platform)
                        @case('linkedin')
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fab fa-linkedin text-blue-600 text-lg"></i>
                            </div>
                            @break
                        @case('github')
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fab fa-github text-gray-800 text-lg"></i>
                            </div>
                            @break
                        @case('twitter')
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                                <i class="fab fa-twitter text-blue-400 text-lg"></i>
                            </div>
                            @break
                        @case('facebook')
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fab fa-facebook text-blue-600 text-lg"></i>
                            </div>
                            @break
                        @case('instagram')
                            <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
                                <i class="fab fa-instagram text-pink-600 text-lg"></i>
                            </div>
                            @break
                        @case('website')
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-globe text-green-600 text-lg"></i>
                            </div>
                            @break
                        @default
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-link text-gray-600 text-lg"></i>
                            </div>
                    @endswitch
                    
                    <div>
                        <h3 class="font-medium text-gray-900">{{ ucfirst($link->platform) }}</h3>
                        @if($link->username)
                        <p class="text-sm text-gray-600">Username: {{ $link->username }}</p>
                        @endif
                        <a href="{{ $link->url }}" target="_blank" class="text-blue-600 text-sm hover:underline block truncate max-w-xs">
                            {{ $link->url }}
                        </a>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $link->is_public ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $link->is_public ? 'Public' : 'Private' }}
                        </span>
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <button onclick="editSocialLink({{ $link->id }}, '{{ $link->platform }}', '{{ $link->url }}', '{{ $link->username }}', {{ $link->is_public ? 'true' : 'false' }})" 
                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Edit
                    </button>
                    <form action="{{ route('job-seeker.profile.social-link.destroy', $link) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" 
                                class="text-red-600 hover:text-red-800 text-sm font-medium" 
                                onclick="return confirm('Are you sure you want to delete this social link?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        
        @if($socialLinks->isEmpty())
        <div class="text-center py-8 border-2 border-gray-300 border-dashed rounded-lg">
            <i class="fas fa-share-alt text-gray-400 text-4xl mb-3"></i>
            <p class="text-gray-500">No social links added yet.</p>
            <p class="text-gray-400 text-sm mt-1">Click "Add Social Link" to add your social media profiles.</p>
        </div>
        @endif
    </div>
</div>

            <!-- Visibility Settings -->
            <div id="visibility" class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Profile Visibility Settings</h2>
                <form action="{{ route('job-seeker.profile.visibility.update') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-700">Profile Visibility</h3>
                                <p class="text-sm text-gray-500">Control who can see your profile</p>
                            </div>
                            <select name="profile_visibility" class="px-3 py-2 border border-gray-300 rounded-md">
                                <option value="public" {{ ($visibilitySettings->profile_visibility ?? '') == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ ($visibilitySettings->profile_visibility ?? '') == 'private' ? 'selected' : '' }}>Private</option>
                                <option value="recruiters_only" {{ ($visibilitySettings->profile_visibility ?? '') == 'recruiters_only' ? 'selected' : '' }}>Recruiters Only</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-700">Contact Information</h3>
                                <p class="text-sm text-gray-500">Show your contact details on profile</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_contact_info" value="1" class="sr-only peer" {{ ($visibilitySettings->show_contact_info ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-700">Show Resume</h3>
                                <p class="text-sm text-gray-500">Allow recruiters to download your resume</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="show_resume" value="1" class="sr-only peer" {{ ($visibilitySettings->show_resume ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-700">Email Notifications</h3>
                                <p class="text-sm text-gray-500">Receive job alerts and updates</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="email_notifications" value="1" class="sr-only peer" {{ ($visibilitySettings->email_notifications ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save Visibility Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle functions for forms
function toggleEducationForm() {
    document.getElementById('educationForm').classList.toggle('hidden');
}

function toggleEditEducationForm() {
    document.getElementById('editEducationForm').classList.toggle('hidden');
}

function toggleSkillForm() {
    document.getElementById('skillForm').classList.toggle('hidden');
}

function toggleExperienceForm() {
    document.getElementById('experienceForm').classList.toggle('hidden');
}

function toggleEditExperienceForm() {
    document.getElementById('editExperienceForm').classList.toggle('hidden');
}

function toggleProjectForm() {
    document.getElementById('projectForm').classList.toggle('hidden');
}

function toggleEditProjectForm() {
    document.getElementById('editProjectForm').classList.toggle('hidden');
}

function toggleCertificationForm() {
    document.getElementById('certificationForm').classList.toggle('hidden');
}

function toggleEditCertificationForm() {
    document.getElementById('editCertificationForm').classList.toggle('hidden');
}

// Edit functions
function editEducation(id, institution, degree, startDate, endDate, isCurrent) {
    document.getElementById('editEducationForm').classList.remove('hidden');
    document.getElementById('edit_institution').value = institution;
    document.getElementById('edit_degree').value = degree;
    document.getElementById('edit_start_date').value = startDate;
    document.getElementById('edit_end_date').value = endDate;
    document.getElementById('edit_is_current').checked = isCurrent;
    
    // Set form action
    const form = document.getElementById('editEducationFormElement');
    form.action = `/job-seeker/profile/education/${id}`;
    
    // Scroll to form
    document.getElementById('editEducationForm').scrollIntoView({ behavior: 'smooth' });
}

function editExperience(id, jobTitle, companyName, employmentType, location, startDate, endDate, isCurrent, description) {
    document.getElementById('editExperienceForm').classList.remove('hidden');
    document.getElementById('edit_job_title').value = jobTitle;
    document.getElementById('edit_company_name').value = companyName;
    document.getElementById('edit_employment_type').value = employmentType;
    document.getElementById('edit_location').value = location;
    document.getElementById('edit_experience_start_date').value = startDate;
    document.getElementById('edit_experience_end_date').value = endDate;
    document.getElementById('edit_experience_is_current').checked = isCurrent === 'true';
    document.getElementById('edit_experience_description').value = description;
    
    // Set form action
    const form = document.getElementById('editExperienceFormElement');
    form.action = `/job-seeker/profile/experience/${id}`;
    
    // Scroll to form
    document.getElementById('editExperienceForm').scrollIntoView({ behavior: 'smooth' });
}

function editProject(id, title, role, startDate, endDate, isOngoing, description, projectUrl) {
    document.getElementById('editProjectForm').classList.remove('hidden');
    document.getElementById('edit_project_title').value = title;
    document.getElementById('edit_project_role').value = role;
    document.getElementById('edit_project_start_date').value = startDate;
    document.getElementById('edit_project_end_date').value = endDate;
    document.getElementById('edit_project_is_ongoing').checked = isOngoing === 'true';
    document.getElementById('edit_project_description').value = description;
    document.getElementById('edit_project_url').value = projectUrl;
    
    // Set form action
    const form = document.getElementById('editProjectFormElement');
    form.action = `/job-seeker/profile/project/${id}`;
    
    // Scroll to form
    document.getElementById('editProjectForm').scrollIntoView({ behavior: 'smooth' });
}

function editCertification(id, name, issuingOrganization, issueDate, expirationDate, credentialId, credentialUrl) {
    document.getElementById('editCertificationForm').classList.remove('hidden');
    document.getElementById('edit_certification_name').value = name;
    document.getElementById('edit_issuing_organization').value = issuingOrganization;
    document.getElementById('edit_issue_date').value = issueDate;
    document.getElementById('edit_expiration_date').value = expirationDate;
    document.getElementById('edit_credential_id').value = credentialId;
    document.getElementById('edit_credential_url').value = credentialUrl;
    
    // Set form action
    const form = document.getElementById('editCertificationFormElement');
    form.action = `/job-seeker/profile/certification/${id}`;
    
    // Scroll to form
    document.getElementById('editCertificationForm').scrollIntoView({ behavior: 'smooth' });
}

// Social Link Functions
function toggleSocialLinkForm() {
    document.getElementById('socialLinkForm').classList.toggle('hidden');
}

function toggleEditSocialLinkForm() {
    document.getElementById('editSocialLinkForm').classList.toggle('hidden');
}

function editSocialLink(id, platform, url, username, isPublic) {
    document.getElementById('editSocialLinkForm').classList.remove('hidden');
    document.getElementById('edit_social_platform').value = platform;
    document.getElementById('edit_social_url').value = url;
    document.getElementById('edit_social_username').value = username || '';
    document.getElementById('edit_social_is_public').checked = isPublic === 'true';
    
    // Set form action
    const form = document.getElementById('editSocialLinkFormElement');
    form.action = `/job-seeker/profile/social-link/${id}`;
    
    // Scroll to form
    document.getElementById('editSocialLinkForm').scrollIntoView({ behavior: 'smooth' });
}

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            // Update active state in sidebar
            document.querySelectorAll('#sidebar a').forEach(link => {
                link.classList.remove('text-blue-600');
                link.classList.add('text-gray-600');
            });
            this.classList.remove('text-gray-600');
            this.classList.add('text-blue-600');
            
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Handle is_current checkbox for education
document.querySelectorAll('input[name="is_current"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const endDateInput = this.closest('form').querySelector('input[name="end_date"]');
        if (this.checked) {
            endDateInput.disabled = true;
            endDateInput.value = '';
        } else {
            endDateInput.disabled = false;
        }
    });
});

// Handle is_ongoing checkbox for projects
document.querySelectorAll('input[name="is_ongoing"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const endDateInput = this.closest('form').querySelector('input[name="end_date"]');
        if (this.checked) {
            endDateInput.disabled = true;
            endDateInput.value = '';
        } else {
            endDateInput.disabled = false;
        }
    });
});

// Initialize date inputs
document.addEventListener('DOMContentLoaded', function() {
    // Disable end dates if is_current/is_ongoing is checked
    document.querySelectorAll('input[name="is_current"]:checked').forEach(checkbox => {
        const endDateInput = checkbox.closest('form').querySelector('input[name="end_date"]');
        if (endDateInput) endDateInput.disabled = true;
    });
    
    document.querySelectorAll('input[name="is_ongoing"]:checked').forEach(checkbox => {
        const endDateInput = checkbox.closest('form').querySelector('input[name="end_date"]');
        if (endDateInput) endDateInput.disabled = true;
    });
});
</script>

<style>
/* Additional custom styles */
.hidden {
    display: none;
}

/* Smooth transition for form toggles */
#educationForm,
#editEducationForm,
#skillForm,
#experienceForm,
#editExperienceForm,
#projectForm,
#editProjectForm,
#certificationForm,
#editCertificationForm {
    transition: all 0.3s ease-in-out;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endsection