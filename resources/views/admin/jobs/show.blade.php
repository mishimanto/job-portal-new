@extends('layouts.admin')

@section('title', 'Job Details - Admin Panel')
@section('page-title', 'Job Details')

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
            Details
        </span>
    </div>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Job Header -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h1>
                    <div class="mt-2 flex items-center space-x-4">
                        <span class="text-lg font-semibold text-gray-700">{{ $job->company_name }}</span>
                        <span class="text-gray-500">•</span>
                        <span class="text-gray-600">{{ $job->location }}</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($job->status == 'approved') bg-green-100 text-green-800
                        @elseif($job->status == 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($job->status) }}
                    </span> -->
                    
                    @if($job->status == 'pending')
                    <div class="flex space-x-2">
                        <form method="POST" action="{{ route('admin.jobs.update-status', $job) }}">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.jobs.update-status', $job) }}">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Reject
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Job Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Job Description -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Job Description
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="prose max-w-none">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Job Requirements -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Requirements
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    @if($job->skills_required && is_array($job->skills_required))
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Skills Required</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($job->skills_required as $skill)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $skill }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @elseif($job->skills_required && is_string($job->skills_required))
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Skills Required</h4>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $skills = json_decode($job->skills_required);
                                if (json_last_error() !== JSON_ERROR_NONE) {
                                    $skills = explode(',', $job->skills_required);
                                }
                            @endphp
                            @if(is_array($skills))
                                @foreach($skills as $skill)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ trim($skill) }}
                                </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Job Type</h4>
                            <p class="text-sm text-gray-900">{{ ucfirst(str_replace('-', ' ', $job->job_type)) }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Experience Level</h4>
                            <p class="text-sm text-gray-900">
                                @if($job->experience_level == 'intern') Intern
                                @elseif($job->experience_level == 'junior') Junior (0-2 years)
                                @elseif($job->experience_level == 'mid') Mid Level (2-5 years)
                                @elseif($job->experience_level == 'senior') Senior (5+ years)
                                @elseif($job->experience_level == 'lead') Lead/Manager
                                @elseif($job->experience_level == 'executive') Executive
                                @else {{ ucfirst($job->experience_level) }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Salary</h4>
                            <p class="text-sm text-gray-900">
                                @if($job->is_negotiable)
                                    <span class="text-gray-600 italic">Negotiable</span>
                                @elseif($job->salary)
                                    {{ $job->salary }}
                                @elseif($job->salary_min && $job->salary_max)
                                    @php
                                        $currencySymbol = '$';
                                        if($job->salary_currency == 'EUR') $currencySymbol = '€';
                                        elseif($job->salary_currency == 'GBP') $currencySymbol = '£';
                                        elseif($job->salary_currency == 'BDT') $currencySymbol = '৳';
                                        elseif($job->salary_currency == 'INR') $currencySymbol = '₹';
                                    @endphp
                                    {{ $currencySymbol }} {{ number_format($job->salary_min) }} - {{ $currencySymbol }} {{ number_format($job->salary_max) }} 
                                @elseif($job->salary_min)
                                    @php
                                        $currencySymbol = '$';
                                        if($job->salary_currency == 'EUR') $currencySymbol = '€';
                                        elseif($job->salary_currency == 'GBP') $currencySymbol = '£';
                                        elseif($job->salary_currency == 'BDT') $currencySymbol = '৳';
                                        elseif($job->salary_currency == 'INR') $currencySymbol = '₹';
                                    @endphp
                                    {{ $currencySymbol }} {{ number_format($job->salary_min) }} 
                                @else
                                    <span class="text-gray-500 italic">Not specified</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Application Deadline</h4>
                            <p class="text-sm text-gray-900">{{ $job->application_deadline?->format('M d, Y') ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posted By -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Posted By
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                <span class="text-white font-bold text-sm">
                                    {{ strtoupper(substr($job->user->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">{{ $job->user->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $job->user->email }}</p>
                            <p class="text-sm text-gray-600">{{ $job->user->phone ?? 'No phone number' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Quick Stats
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="space-y-4">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm font-medium text-gray-500">Total Views</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $job->views }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm font-medium text-gray-500">Applications</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $job->applications_count }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm font-medium text-gray-500">Posted Date</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $job->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $job->updated_at->format('M d, Y') }}</dd>
                        </div>
                        <!-- <div class="flex items-center justify-between">
                            <dt class="text-sm font-medium text-gray-500">Salary Type</dt>
                            <dd class="text-sm font-semibold text-gray-900">
                                @if($job->is_negotiable)
                                    <span class="text-yellow-600">Negotiable</span>
                                @elseif($job->salary_min && $job->salary_max)
                                    <span class="text-blue-600">Range</span>
                                @elseif($job->salary_min || $job->salary_max)
                                    <span class="text-green-600">Fixed</span>
                                @else
                                    <span class="text-gray-500">Not set</span>
                                @endif
                            </dd>
                        </div> -->
                    </dl>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Actions
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-3">
                        @if($job->status == 'pending')
                        <form method="POST" action="{{ route('admin.jobs.update-status', $job) }}" class="w-full">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Approve Job
                            </button>
                        </form>
                        
                        <form method="POST" action="{{ route('admin.jobs.update-status', $job) }}" class="w-full">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Reject Job
                            </button>
                        </form>
                        @endif
                        
                        <div class="flex space-x-2 w-full mx-auto">
                            <a href="{{ route('admin.jobs.edit', $job) }}" 
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Job
                            </a>

                            <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        onclick="if(confirm('Are you sure you want to delete this job?')) this.form.submit()"
                                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete Job
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Benefits -->
            @if($job->benefits)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Benefits
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <ul class="space-y-2">
                        @php
                            // Handle benefits as both array and JSON string
                            $benefits = $job->benefits;
                            if (is_string($benefits)) {
                                $benefits = json_decode($benefits, true);
                                if (json_last_error() !== JSON_ERROR_NONE) {
                                    $benefits = explode("\n", $benefits);
                                }
                            }
                        @endphp
                        
                        @if(is_array($benefits))
                            @foreach($benefits as $benefit)
                                @if(!empty(trim($benefit)))
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ trim($benefit) }}</span>
                                </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            @endif

            <!-- Category Info -->
            @if($job->category)
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Category
                    </h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center space-x-3">
                        @if($job->category->icon)
                        <div class="flex-shrink-0">
                            <span class="text-2xl">{{ $job->category->icon }}</span>
                        </div>
                        @endif
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900">{{ $job->category->name }}</h4>
                            @if($job->category->description)
                            <p class="text-sm text-gray-500 mt-1">{{ $job->category->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection