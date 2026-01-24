@extends('layouts.admin')

@section('title', 'Applications - Admin Panel')
@section('page-title', 'Job Applications')
@section('page-subtitle', 'Manage all job applications')

@section('content')
<div class="space-y-6">
    <!-- Applications List -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Applications ({{ $applications->total() }})
                    </h3>
                    <!-- <p class="mt-1 text-sm text-gray-500">
                        Total {{ $applications->total() }} applications found
                    </p> -->
                </div>
                <div class="">
                    <form method="GET" action="{{ route('admin.applications.index') }}" class="flex flex-wrap items-end gap-4">
                        <!-- Status -->
                        <div class="flex-1 min-w-[150px]">
                            <!-- <label for="status" class="block text-sm font-medium text-gray-700">Status</label> -->
                            <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>Hired</option>
                            </select>
                        </div>

                        <!-- Job -->
                        <div class="flex-1 min-w-[150px]">
                            <!-- <label for="job" class="block text-sm font-medium text-gray-700">Job</label> -->
                            <select name="job_id" id="job" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Jobs</option>
                                @foreach($jobs as $job)
                                <option value="{{ $job->id }}" {{ request('job_id') == $job->id ? 'selected' : '' }}>
                                    {{ $job->title }} - {{ $job->company_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="flex-1 min-w-[150px]">
                            <!-- <label for="date" class="block text-sm font-medium text-gray-700">Date Range</label> -->
                            <input type="date" name="date" id="date" value="{{ request('date') }}" 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3">
                            <a href="{{ route('admin.applications.index') }}" 
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Reset
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        @if($applications->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applicant
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applied for
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Company
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applied Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($applications as $application)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @if($application->user && $application->user->profile_photo)
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" 
                                            src="{{ Storage::url($application->user->profile_photo) }}" 
                                            alt="{{ $application->user->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">
                                                {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $application->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $application->user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $application->job->title }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $application->job->job_type }} • {{ $application->job->experience_level }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $application->job->company_name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $application->applied_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400">
                                {{ $application->applied_at->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($application->status == 'hired') bg-green-100 text-green-800
                                @elseif($application->status == 'shortlisted') bg-blue-100 text-blue-800
                                @elseif($application->status == 'reviewed') bg-yellow-100 text-yellow-800
                                @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.applications.show', $application) }}" 
                                   class="text-indigo-600 hover:text-indigo-900"
                                   title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                
                                <!-- <button type="button" 
                                        onclick="updateStatus('{{ $application->id }}', 'shortlisted')"
                                        class="text-blue-600 hover:text-blue-900 {{ $application->status == 'shortlisted' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        title="Shortlist"
                                        {{ $application->status == 'shortlisted' ? 'disabled' : '' }}>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button> -->
                                
                                <button type="button" 
                                        onclick="updateStatus('{{ $application->id }}', 'rejected')"
                                        class="text-red-600 hover:text-red-900 {{ $application->status == 'rejected' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        title="Reject"
                                        {{ $application->status == 'rejected' ? 'disabled' : '' }}>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $applications->links() }}
        </div>

        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications found</h3>
            <!-- <p class="mt-1 text-sm text-gray-500">Get started by viewing job listings.</p> -->
        </div>
        @endif
    </div>
</div>

<!-- Update Status Form -->
<form id="status-form" method="POST" style="display: none;">
    @csrf
    @method('POST')
    <input type="hidden" name="status" id="status-input">
</form>

@push('scripts')
<script>
function updateStatus(applicationId, status) {
    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to ${status} this application?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('status-form');
            form.action = `/admin/applications/${applicationId}/status`;
            document.getElementById('status-input').value = status;
            form.submit();
        }
    });
}
</script>
@endpush
@endsection