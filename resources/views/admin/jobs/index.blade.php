@extends('layouts.admin')

@section('title', 'Jobs - Admin Panel')
@section('page-title', 'Job Management')
@section('page-subtitle', 'Manage all job postings')

@section('content')
<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Jobs</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $totalJobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Approval</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $pendingJobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 01118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Active Jobs</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $activeJobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs List -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        All Jobs ({{ $jobs->total() }})
                    </h3>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search jobs..." 
                               class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500"
                               id="search-input">
                        <div class="absolute left-3 top-2.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.jobs.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Post Job
                    </a>
                </div>
            </div>
        </div>
        
        @if($jobs->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Job Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category 
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Posted By
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Application Deadline
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Applications
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Posted Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($jobs as $job)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $job->title }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $job->location }} • {{ ucfirst($job->job_type) }}
                            </div>
                            <div class="text-xs mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    @if($job->status == 'approved') bg-green-100 text-green-800
                                    @elseif($job->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($job->status) }}
                                </span>
                                @if(!$job->is_active)
                                <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($job->category)
                                <span class="text-sm font-medium text-blue-600">
                                    {{ $job->category->name }}
                                </span>
                            @else
                                <span class="text-sm font-medium text-gray-500">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $job->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $job->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($job->application_deadline)
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    @php
                                        $deadline = \Carbon\Carbon::parse($job->application_deadline)->startOfDay();
                                        $now = \Carbon\Carbon::now()->startOfDay();
                                        
                                        if($deadline->lt($now)) {
                                            echo '<span class="text-red-600">Expired</span>';
                                        } else {
                                            $daysLeft = $now->diffInDays($deadline);
                                            
                                            if($daysLeft == 0) {
                                                echo '<span class="text-orange-600">Ends today</span>';
                                            } elseif($daysLeft == 1) {
                                                echo '<span class="text-orange-600">1 day left</span>';
                                            } elseif($daysLeft <= 7) {
                                                echo '<span class="text-yellow-600">'.$daysLeft.' days left</span>';
                                            } else {
                                                echo $daysLeft.' days left';
                                            }
                                        }
                                    @endphp
                                </div>
                            @else
                                <span class="text-sm text-gray-500">No deadline</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $job->applications_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $job->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.jobs.show', $job) }}" 
                                   class="text-blue-600 hover:text-blue-900"
                                   title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.jobs.edit', $job) }}"
                                    class="text-blue-600 hover:text-blue-900"
                                    title="Edit Job">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.586 2.586a2 2 0 112.828 2.828L11.828 15
                                                    H9v-2.828l9.586-9.586z"/>
                                    </svg>
                                </a>

                                @if($job->status == 'pending')
                                <button type="button" 
                                        onclick="updateJobStatus('{{ $job->id }}', 'approved', 'Approve Job', 'Are you sure you want to approve this job?', 'success')"
                                        class="text-green-600 hover:text-green-900"
                                        title="Approve Job">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                                
                                <button type="button" 
                                        onclick="updateJobStatus('{{ $job->id }}', 'rejected', 'Reject Job', 'Are you sure you want to reject this job?', 'error')"
                                        class="text-red-600 hover:text-red-900"
                                        title="Reject Job">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                @endif
                                
                                <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="inline" id="delete-form-{{ $job->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete('{{ $job->id }}', '{{ $job->title }}')"
                                            class="text-gray-600 hover:text-gray-900"
                                            title="Delete Job">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $jobs->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No jobs found</h3>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function updateJobStatus(jobId, status, title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('status-form');
            form.action = `/admin/jobs/${jobId}/status`;
            document.getElementById('status-input').value = status;
            form.submit();
        }
    });
}

function confirmDelete(jobId, jobTitle) {
    Swal.fire({
        title: 'Delete Job',
        html: `Are you sure you want to delete <strong>${jobTitle}</strong>?<br><span class="text-sm text-red-600">This action cannot be undone!</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${jobId}`).submit();
        }
    });
}

// Simple search functionality
document.getElementById('search-input').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        const searchTerm = this.value.trim();
        if (searchTerm) {
            window.location.href = '{{ route("admin.jobs.index") }}?search=' + encodeURIComponent(searchTerm);
        }
    }
});
</script>
@endpush
@endsection