@extends('layouts.admin')

@section('title', $company->name . ' - Admin Panel')
@section('page-title', $company->name)
@section('page-subtitle', 'Company Details')

@section('content')
<div class="space-y-6">
    <!-- Company Header -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Company Logo -->
                    <div class="flex-shrink-0">
                        @if($company->logo)
                            <img src="{{ Storage::url($company->logo) }}" 
                                 alt="{{ $company->name }}"
                                 class="h-16 w-16 rounded-full object-cover border-2 border-white shadow">
                        @else
                            <div class="h-16 w-16 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center border-2 border-white shadow">
                                <span class="text-white text-xl font-bold">{{ substr($company->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Company Info -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">{{ $company->name }}</h2>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($company->is_active) bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $company->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($company->industry)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $company->industry }}
                                </span>
                            @endif
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ $company->jobs_count }} jobs
                            </span>
                        </div>
                        <div class="flex items-center space-x-4 mt-1">
                            @if($company->email)
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $company->email }}
                                </p>
                            @endif
                            @if($company->phone)
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $company->phone }}
                                </p>
                            @endif
                            @if($company->website)
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    <a href="{{ $company->website }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                        Website
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.companies.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Back to Companies
                    </a>
                    <a href="{{ route('admin.companies.edit', $company) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit Company
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Company Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            @if($company->description)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            About {{ $company->name }}
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <div class="prose max-w-none">
                            {{ $company->description }}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Company Jobs -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Posted Jobs
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $jobs->total() }} total
                        </span>
                    </div>
                </div>
                
                @if($jobs->isEmpty())
                    <div class="px-6 py-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No jobs posted yet</h3>
                        <p class="mt-1 text-sm text-gray-500">This company hasn't posted any jobs yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Job Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Applications
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Posted
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
                                                {{ $job->location }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($job->job_type == 'full_time') bg-green-100 text-green-800
                                                @elseif($job->job_type == 'part_time') bg-yellow-100 text-yellow-800
                                                @elseif($job->job_type == 'contract') bg-purple-100 text-purple-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($job->status == 'active') bg-green-100 text-green-800
                                                @elseif($job->status == 'expired') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($job->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $job->applications_count ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $job->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($jobs->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">
            <!-- Company Info -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Company Information
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="space-y-4">
                        @if($company->industry)
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Industry</dt>
                                <dd class="text-sm text-gray-900">{{ $company->industry }}</dd>
                            </div>
                        @endif
                        
                        @if($company->location)
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Location</dt>
                                <dd class="text-sm text-gray-900">{{ $company->location }}</dd>
                            </div>
                        @endif
                        
                        @if($company->size)
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Company Size</dt>
                                <dd class="text-sm text-gray-900">{{ $company->size }} employees</dd>
                            </div>
                        @endif
                        
                        @if($company->founded_date)
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Founded</dt>
                                <dd class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($company->founded_date)->format('Y') }}
                                </dd>
                            </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="text-sm text-gray-900">
                                {{ $company->created_at->format('M d, Y') }}
                            </dd>
                        </div>
                        
                        <div class="flex justify-between">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="text-sm text-gray-900">
                                {{ $company->updated_at->format('M d, Y') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Quick Actions
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this company? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Company
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.companies.edit', $company) }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Company
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection