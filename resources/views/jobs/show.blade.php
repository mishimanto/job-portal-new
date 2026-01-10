@extends('layouts.app')

@section('title', "{$job->title} | Join Our Team")

@push('styles')
<style>
    .tab-button {
        transition: all 0.3s ease;
    }
    
    .tab-button.active {
        color: #4f46e5;
        border-bottom-color: #4f46e5;
    }
    
    .tab-panel {
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endpush

@section('content')
<section class="max-w-7xl mx-auto p-6 bg-white rounded-xl shadow-lg space-y-6 mt-10">

    <!-- Job Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            @if($job->company_logo)
                <img src="{{ asset('storage/' . $job->company_logo) }}" 
                     alt="{{ $job->company_name }}" 
                     class="w-16 h-16 rounded-lg object-cover border border-gray-200">
            @else
                <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr($job->company_name, 0, 2) }}
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                <p class="text-gray-600">{{ $job->company_name }}</p>
                @if($job->application_deadline)
                    <p class="text-pink-600 font-medium">
                        Application Deadline: {{ $job->application_deadline->format('d M Y') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-3">
            @auth
                @if(auth()->user()->isJobSeeker())
                    @php
                        $hasApplied = $job->applications()
                            ->where('user_id', auth()->id())
                            ->exists();
                    @endphp
                    
                    @if($hasApplied)
                        <button class="bg-green-100 text-green-800 px-4 py-2 rounded-lg font-medium cursor-default">
                            ✓ Applied
                        </button>
                    @else
                        <!-- Apply Form (POST method) -->
                        <form action="{{ route('jobs.apply', $job) }}" method="POST" id="quickApplyForm" class="hidden">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                Quick Apply
                            </button>
                        </form>
                        
                        <button onclick="showApplyModal()" 
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-medium">
                            Apply Now
                        </button>
                    @endif
                @elseif(auth()->user()->isAdmin())
                    <a href="{{ route('admin.jobs.edit', $job) }}" 
                       class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-medium">
                        Edit Job
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-medium">
                    Login to Apply
                </a>
                <a href="{{ route('register') }}" 
                   class="border border-indigo-600 text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-50 transition font-medium">
                    Register
                </a>
            @endauth
            
            <!-- Share Button -->
            <button onclick="shareJob()" 
                    class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition font-medium">
                Share
            </button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-4 overflow-x-auto" aria-label="Tabs">
            <button onclick="showTab('all')" 
                    class="tab-button text-indigo-600 border-b-2 border-indigo-600 px-3 py-2 font-medium text-sm whitespace-nowrap active">
                All Details
            </button>
            <button onclick="showTab('requirements')" 
                    class="tab-button text-gray-500 hover:text-indigo-600 px-3 py-2 font-medium text-sm whitespace-nowrap">
                Requirements
            </button>
            <button onclick="showTab('responsibilities')" 
                    class="tab-button text-gray-500 hover:text-indigo-600 px-3 py-2 font-medium text-sm whitespace-nowrap">
                Responsibilities
            </button>
            <button onclick="showTab('benefits')" 
                    class="tab-button text-gray-500 hover:text-indigo-600 px-3 py-2 font-medium text-sm whitespace-nowrap">
                Benefits
            </button>
            <button onclick="showTab('company')" 
                    class="tab-button text-gray-500 hover:text-indigo-600 px-3 py-2 font-medium text-sm whitespace-nowrap">
                Company Info
            </button>
        </nav>
    </div>

    <!-- Tab Panels -->
    <div class="space-y-6">
        <!-- All Details Panel (Default) -->
        <div id="all-tab" class="tab-panel">
            <!-- Job Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 bg-gray-50 p-6 rounded-lg">
                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500 mb-1">Location</div>
                    <div class="font-semibold text-gray-900">{{ $job->location }}</div>
                </div>
                
                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500 mb-1">Job Type</div>
                    <div class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $job->job_type)) }}</div>
                </div>
                
                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500 mb-1">Experience</div>
                    <div class="font-semibold text-gray-900">{{ ucfirst($job->experience_level) }}</div>
                </div>
                
                <div class="text-center p-4 bg-white rounded-lg shadow-sm">
                    <div class="text-sm text-gray-500 mb-1">Salary</div>
                    <div class="font-semibold text-gray-900">
                        @if($job->salary)
                            ${{ number_format($job->salary) }}/year
                        @else
                            Negotiable
                        @endif
                    </div>
                </div>
            </div>

            <!-- Job Description -->
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Job Description</h3>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </div>

            <!-- Skills Required -->
            @php
                // Helper function to get skills array
                function getSkillsArray($skillsRequired) {
                    if (empty($skillsRequired)) {
                        return [];
                    }
                    
                    if (is_array($skillsRequired)) {
                        return $skillsRequired;
                    }
                    
                    if (is_string($skillsRequired)) {
                        $decoded = json_decode($skillsRequired, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            return $decoded;
                        }
                    }
                    
                    return [];
                }
                
                $skills = getSkillsArray($job->skills_required);
            @endphp

            @if(!empty($skills))
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Required Skills</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($skills as $skill)
                    <span class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium">
                        {{ $skill }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Requirements Panel -->
        <div id="requirements-tab" class="tab-panel hidden">
            <div class="space-y-6">
                <!-- Experience -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Experience Requirements</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">{{ ucfirst($job->experience_level) }} level experience required</p>
                        @if($job->experience_level == 'entry')
                            <p class="text-gray-600 mt-2">Fresh graduates are encouraged to apply</p>
                        @elseif($job->experience_level == 'mid')
                            <p class="text-gray-600 mt-2">3-5 years of relevant experience</p>
                        @elseif($job->experience_level == 'senior')
                            <p class="text-gray-600 mt-2">5+ years of relevant experience</p>
                        @endif
                    </div>
                </div>

                <!-- Education -->
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Educational Qualifications</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">Bachelor's degree in relevant field</p>
                        <p class="text-gray-600 mt-2">Additional certifications will be considered as advantage</p>
                    </div>
                </div>

                <!-- Technical Skills -->
                @if(!empty($skills))
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Technical Skills</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($skills as $skill)
                        <div class="flex items-center bg-white p-3 rounded-lg border border-gray-200">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">{{ $skill }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Responsibilities Panel -->
        <div id="responsibilities-tab" class="tab-panel hidden">
            <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Key Responsibilities</h3>
                
                @php
                    $responsibilities = [
                        'Project planning and execution',
                        'Team coordination and management',
                        'Quality assurance and control',
                        'Client communication and relationship management',
                        'Documentation and reporting',
                        'Continuous improvement and innovation'
                    ];
                    
                    if ($job->description) {
                        // Extract responsibilities from description
                        $descLines = explode("\n", $job->description);
                        $descLines = array_filter($descLines, function($line) {
                            return strlen(trim($line)) > 20;
                        });
                        
                        if (count($descLines) >= 3) {
                            $responsibilities = array_slice($descLines, 0, 6);
                        }
                    }
                @endphp
                
                <ul class="space-y-3">
                    @foreach($responsibilities as $responsibility)
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-gray-700">{{ $responsibility }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Benefits Panel -->
        <div id="benefits-tab" class="tab-panel hidden">
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Benefits & Perks</h3>
                
                @php
                    // Helper function to get benefits array
                    function getBenefitsArray($benefits) {
                        if (empty($benefits)) {
                            return [];
                        }
                        
                        if (is_array($benefits)) {
                            return $benefits;
                        }
                        
                        if (is_string($benefits)) {
                            $decoded = json_decode($benefits, true);
                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                return $decoded;
                            }
                        }
                        
                        return [];
                    }
                    
                    $benefitsArray = getBenefitsArray($job->benefits);
                @endphp
                
                @if(!empty($benefitsArray))
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($benefitsArray as $benefit)
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-lg border border-green-100">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium text-green-800">{{ $benefit }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach(['Competitive Salary', 'Health Insurance', 'Flexible Hours', 'Remote Work Options', 'Learning Budget', 'Paid Time Off'] as $benefit)
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-100">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-medium text-blue-800">{{ $benefit }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
                
                <!-- Salary Info -->
                @if($job->salary)
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-6 rounded-lg border border-yellow-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">Salary Package</h4>
                            <p class="text-gray-600 mt-1">Annual compensation with performance bonuses</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-900">${{ number_format($job->salary) }}</div>
                            <div class="text-gray-600">per year</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Company Info Panel -->
        <div id="company-tab" class="tab-panel hidden">
            <div class="space-y-6">
                <div class="flex items-center gap-4 mb-6">
                    @if($job->company_logo)
                        <img src="{{ asset('storage/' . $job->company_logo) }}" 
                             alt="{{ $job->company_name }}" 
                             class="w-20 h-20 rounded-xl object-cover border border-gray-200">
                    @else
                        <div class="w-20 h-20 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white text-3xl font-bold">
                            {{ substr($job->company_name, 0, 2) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $job->company_name }}</h3>
                        <p class="text-gray-600 mt-1">Industry Leader</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h4 class="font-bold text-gray-900 mb-3">About Company</h4>
                        <p class="text-gray-700">
                            {{ $job->company_name }} is a leading organization in its industry, committed to excellence and innovation. 
                            We provide a dynamic work environment that fosters growth and development.
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h4 class="font-bold text-gray-900 mb-3">Work Culture</h4>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Collaborative Environment
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Work-Life Balance
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Career Growth Opportunities
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Apply Modal -->
<div id="applyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Apply for {{ $job->title }}</h3>
                <button onclick="closeApplyModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            @auth
                @if(auth()->user()->isJobSeeker())
                    @php
                        $hasApplied = $job->applications()
                            ->where('user_id', auth()->id())
                            ->exists();
                    @endphp
                    
                    @if($hasApplied)
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Already Applied</h4>
                            <p class="text-gray-600 mb-6">You have already submitted your application for this position.</p>
                            <a href="{{ route('job-seeker.applications') }}" 
                               class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                                View Application Status
                            </a>
                        </div>
                    @else
                        <!-- Apply Form -->
                        <form action="{{ route('jobs.apply', $job) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="space-y-4">
                                <!-- Applicant Info -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-medium text-gray-900 mb-2">Applicant Information</h4>
                                    <p class="text-sm text-gray-600">
                                        <strong>Name:</strong> {{ auth()->user()->name }}<br>
                                        <strong>Email:</strong> {{ auth()->user()->email }}
                                    </p>
                                </div>

                                <!-- Cover Letter -->
                                <div>
                                    <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">
                                        Cover Letter <span class="text-gray-500">(Optional)</span>
                                    </label>
                                    <textarea id="cover_letter" name="cover_letter" rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                              placeholder="Tell us why you're interested in this position..."></textarea>
                                </div>

                                <!-- Resume -->
                                <div>
                                    <label for="resume" class="block text-sm font-medium text-gray-700 mb-2">
                                        Upload Resume <span class="text-gray-500">(Optional)</span>
                                    </label>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="resume" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500">
                                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                                </p>
                                                <p class="text-xs text-gray-500">PDF, DOC, DOCX (MAX. 5MB)</p>
                                            </div>
                                            <input id="resume" name="resume" type="file" class="hidden" accept=".pdf,.doc,.docx">
                                        </label>
                                    </div>
                                    <div id="resumeName" class="mt-2 text-sm text-gray-500 hidden"></div>
                                    
                                    <!-- Show existing resume if available -->
                                    @if(auth()->user()->jobSeekerProfile && auth()->user()->jobSeekerProfile->resume_file)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">
                                            <svg class="w-4 h-4 inline mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Existing resume will be used if no new file is uploaded
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <button type="submit"
                                            class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 px-4 rounded-lg font-bold hover:from-green-700 hover:to-emerald-700 transition flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        Submit Application
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                @elseif(auth()->user()->isAdmin())
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">Admin Account</h4>
                        <p class="text-gray-600 mb-6">You are logged in as an administrator. Only job seekers can apply for jobs.</p>
                        <a href="{{ route('admin.jobs.edit', $job) }}" 
                           class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                            Edit Job Posting
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Login Required</h4>
                    <p class="text-gray-600 mb-6">Please login as a job seeker to apply for this position.</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('login') }}" 
                           class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="border border-indigo-600 text-indigo-600 px-6 py-2 rounded-lg hover:bg-indigo-50">
                            Register
                        </a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Tab functionality
function showTab(tabName) {
    // Hide all tab panels
    document.querySelectorAll('.tab-panel').forEach(panel => {
        panel.classList.add('hidden');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'text-indigo-600', 'border-indigo-600');
        button.classList.add('text-gray-500', 'hover:text-indigo-600');
        button.classList.remove('border-b-2');
    });
    
    // Show selected tab panel
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active class to clicked button
    const activeButton = document.querySelector(`button[onclick="showTab('${tabName}')"]`);
    activeButton.classList.add('active', 'text-indigo-600', 'border-indigo-600', 'border-b-2');
    activeButton.classList.remove('text-gray-500', 'hover:text-indigo-600');
}

// Apply Modal functionality
function showApplyModal() {
    document.getElementById('applyModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeApplyModal() {
    document.getElementById('applyModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Close modal when clicking outside
document.getElementById('applyModal').addEventListener('click', function(e) {
    if (e.target.id === 'applyModal') {
        closeApplyModal();
    }
});

// Quick apply (without modal)
function quickApply() {
    document.getElementById('quickApplyForm').submit();
}

// File upload display
document.getElementById('resume')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        document.getElementById('resumeName').textContent = 'Selected file: ' + fileName;
        document.getElementById('resumeName').classList.remove('hidden');
    }
});

// Share job functionality
function shareJob() {
    const shareUrl = window.location.href;
    const jobTitle = '{{ $job->title }}';
    
    if (navigator.share) {
        navigator.share({
            title: jobTitle,
            text: 'Check out this job opportunity: ' + jobTitle,
            url: shareUrl,
        });
    } else {
        // Fallback: Copy to clipboard
        navigator.clipboard.writeText(shareUrl).then(() => {
            alert('Link copied to clipboard!');
        });
    }
}

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    showTab('all');
});
</script>
@endpush