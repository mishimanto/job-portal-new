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
                    
                    <!-- <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Status
                            <svg class="-mr-1 ml-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                             style="display: none;">
                            <form method="POST" action="{{ route('admin.applications.update-status', $application) }}">
                                @csrf
                                @method('POST')
                                <button type="submit" name="status" value="reviewed" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $application->status == 'reviewed' ? 'bg-gray-50' : '' }}">
                                    Mark as Reviewed
                                </button>
                                <button type="submit" name="status" value="shortlisted" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $application->status == 'shortlisted' ? 'bg-gray-50' : '' }}">
                                    Shortlist
                                </button>
                                <button type="submit" name="status" value="rejected" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $application->status == 'rejected' ? 'bg-gray-50' : '' }}">
                                    Reject
                                </button>
                                <button type="submit" name="status" value="hired" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $application->status == 'hired' ? 'bg-gray-50' : '' }}">
                                    Mark as Hired
                                </button>
                            </form>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Applicant Information -->
        <div class="lg:col-span-2 space-y-6">
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
                            <div class="h-16 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                <span class="text-white font-bold text-xl">
                                    {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $application->user->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $application->user->email }}</p>
                            <p class="text-sm text-gray-600">{{ $application->user->phone ?? 'No phone number' }}</p>
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
                        </div>
                    </div>
                </div>
            </div>

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
                                    Interview Time & Date *
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
                                    class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Updates
                            </button>
                        </div>
                    </form>
                    
                    <script>
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
                        
                        // Initialize on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            toggleAdditionalFields();
                        });
                        
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
                    </script>
                </div>
            </div>
    </div>
</div>
@endsection