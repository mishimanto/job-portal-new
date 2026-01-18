@extends('layouts.admin')

@section('title', 'Admin Dashboard - JobPortal')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name . '!')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .chart-container {
        position: relative;
        width: 100%;
    }
    
    .stats-card {
        transition: transform 0.2s;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Jobs -->
        <div class="stats-card bg-white overflow-hidden shadow rounded-lg">
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
                            <dd class="text-lg font-semibold text-gray-900">{{ $total_jobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Jobs -->
        <div class="stats-card bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Jobs</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $pending_jobs }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="stats-card bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Applications</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $total_applications }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Hires -->
        <div class="stats-card bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.667.916-1.583 1.5-2.6 1.5h-1.3c-1.02 0-1.9-.592-2.6-1.5"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Hires</dt>
                            <dd class="text-lg font-semibold text-gray-900">{{ $total_hires }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- First Row of Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Job Status Distribution -->
        <x-charts.pie-chart
            chartId="jobStatusChart"
            title="Job Status Distribution"
            subtitle="Current status of job postings"
            :labels="array_values($job_status_data['labels'])"
            :data="array_values($job_status_data['data'])"
            :colors="array_values($job_status_data['colors'])"
            :borderColors="array_map(function($color) {
                return str_replace('0.8', '1', $color);
            }, array_values($job_status_data['colors']))"
        />
        
        <!-- Experience Level Distribution -->
        @if(!empty($experience_data['data']))
        <x-charts.pie-chart
            chartId="experienceChart"
            title="Experience Level Distribution"
            subtitle="Required experience for jobs"
            :labels="array_keys($experience_data['data'])"
            :data="array_values($experience_data['data'])"
            :colors="array_values(array_intersect_key($experience_data['colors'], $experience_data['data']))"
            :borderColors="array_map(function($color) {
                return str_replace('0.8', '1', $color);
            }, array_values(array_intersect_key($experience_data['colors'], $experience_data['data'])))"
        />
        @endif
        
    </div>

    <!-- Second Row of Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Jobs by Category -->
        @if(!empty($category_data))
        <x-charts.bar-chart
            chartId="categoryChart"
            title="Jobs by Category"
            subtitle="Distribution of jobs across categories"
            :labels="array_column($category_data, 'name')"
            :data="array_column($category_data, 'count')"
            backgroundColor="rgba(59, 130, 246, 0.7)"
            borderColor="rgb(59, 130, 246)"
            datasetLabel="Jobs"
            yAxisTitle="Number of Jobs"
            xAxisTitle="Categories"
            showLegend="false"
        />
        @endif

        

        <!-- Application Status Distribution -->
        <x-charts.bar-chart
            chartId="applicationStatusChart"
            title="Application Status Distribution"
            subtitle="Status of job applications"
            :labels="array_values($app_status_data['labels'])"
            :data="array_values($app_status_data['data'])"
            :backgroundColor="array_values($app_status_data['colors'])"
            :borderColor="array_map(function($color) {
                return str_replace('0.8', '1', $color);
            }, array_values($app_status_data['colors']))"
            datasetLabel="Applications"
            yAxisTitle="Number of Applications"
            xAxisTitle="Status"
        />
    </div>

    <!-- Monthly Statistics Chart -->
    <x-charts.line-chart
        chartId="monthlyStatsChart"
        title="Monthly Statistics"
        subtitle="Job postings and applications over time"
        :labels="$monthly_stats['months']"
        :datasets="[
            [
                'label' => 'Jobs Posted',
                'data' => $monthly_stats['jobs'],
                'borderColor' => 'rgb(59, 130, 246)',
                'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                'tension' => 0.3
            ],
            [
                'label' => 'Applications',
                'data' => $monthly_stats['applications'],
                'borderColor' => 'rgb(34, 197, 94)',
                'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                'tension' => 0.3
            ]
        ]"
        yAxisTitle="Count"
        xAxisTitle="Months"
    />

    <!-- Recent Data Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Jobs -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Recent Job Postings
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Latest jobs awaiting approval
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if($recent_jobs->count() > 0)
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($recent_jobs as $job)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm">
                                                    <a href="{{ route('admin.jobs.show', $job) }}" class="font-medium text-gray-900 hover:text-indigo-600">
                                                        {{ $job->title }}
                                                    </a>
                                                </div>
                                                <p class="mt-0.5 text-sm text-gray-500">
                                                    {{ $job->company_name }} • {{ $job->location }}
                                                </p>
                                            </div>
                                            <div class="mt-2 text-sm">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    {{ ucfirst($job->status) }}
                                                </span>
                                                <span class="ml-2 text-gray-500">
                                                    {{ $job->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No pending jobs</h3>
                        <p class="mt-1 text-sm text-gray-500">All jobs are approved.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Recent Applications
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Latest job applications
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if($recent_applications->count() > 0)
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($recent_applications as $application)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm">
                                                    <a href="{{ route('admin.applications.show', $application) }}" class="font-medium text-gray-900 hover:text-indigo-600">
                                                        {{ $application->user->name }}
                                                    </a>
                                                </div>
                                                <p class="mt-0.5 text-sm text-gray-500">
                                                    Applied for {{ $application->job->title }}
                                                </p>
                                            </div>
                                            <div class="mt-2 text-sm">
                                                @php
                                                    $statusColors = [
                                                        'hired' => 'bg-green-100 text-green-800',
                                                        'shortlisted' => 'bg-blue-100 text-blue-800',
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'reviewed' => 'bg-indigo-100 text-indigo-800',
                                                        'rejected' => 'bg-red-100 text-red-800'
                                                    ];
                                                    $colorClass = $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                                <span class="ml-2 text-gray-500">
                                                    {{ $application->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                        <p class="mt-1 text-sm text-gray-500">Applications will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Quick Actions
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Common administrative tasks
            </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <a href="{{ route('admin.jobs.index') }}" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Manage Jobs</p>
                        <p class="text-sm text-gray-500 truncate">Approve or reject jobs</p>
                    </div>
                </a>

                <a href="{{ route('admin.applications.index') }}" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Applications</p>
                        <p class="text-sm text-gray-500 truncate">Review applications</p>
                    </div>
                </a>

                <a href="{{ route('admin.users.index') }}" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.667.916-1.583 1.5-2.6 1.5h-1.3c-1.02 0-1.9-.592-2.6-1.5"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Users</p>
                        <p class="text-sm text-gray-500 truncate">Manage users</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection