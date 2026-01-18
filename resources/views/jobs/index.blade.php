@extends('layouts.app')

@section('title', 'Careers | Join Our Team')

@section('content')
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Active Filters - Top -->
        @if(request()->anyFilled(['search', 'location', 'job_type', 'experience_level', 'salary_min', 'salary_max', 'categories']))
        <div class="mb-6 bg-gray-50 rounded-lg p-4">
            <div class="flex justify-between items-center mb-2">
                <h4 class="font-semibold text-gray-900 text-sm">Active Filters:</h4>
                <a href="{{ route('jobs.index') }}" class="text-xs text-red-600 hover:text-red-800">
                    Clear All
                </a>
            </div>
            <div class="flex flex-wrap gap-2">
                @php
                    function removeFilter($key, $value = null) {
                        $query = request()->query();
                        
                        if ($value && isset($query[$key]) && is_array($query[$key])) {
                            $query[$key] = array_diff($query[$key], [$value]);
                            if (empty($query[$key])) {
                                unset($query[$key]);
                            }
                        } else {
                            unset($query[$key]);
                        }
                        
                        unset($query['page']);
                        $url = url()->current();
                        return !empty($query) ? $url . '?' . http_build_query($query) : $url;
                    }
                @endphp
                
                @foreach(request()->all() as $key => $value)
                    @if(!in_array($key, ['page', '_token']) && !empty($value))
                        @if(is_array($value))
                            @foreach($value as $item)
                                <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full inline-flex items-center">
                                    @if($key == 'categories')
                                        {{ $categories->where('id', $item)->first()->name ?? $item }}
                                    @else
                                        {{ $item }}
                                    @endif
                                    <a href="{{ removeFilter($key, $item) }}" class="ml-1 text-indigo-600 hover:text-indigo-800">×</a>
                                </span>
                            @endforeach
                        @else
                            <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full inline-flex items-center">
                                @if($key == 'search')
                                    Search: {{ $value }}
                                @elseif($key == 'location')
                                    Location: {{ $value }}
                                @elseif($key == 'salary_min')
                                    Min: ${{ number_format($value) }}
                                @elseif($key == 'salary_max')
                                    Max: ${{ number_format($value) }}
                                @else
                                    {{ $value }}
                                @endif
                                <a href="{{ removeFilter($key) }}" class="ml-1 text-indigo-600 hover:text-indigo-800">×</a>
                            </span>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Side - Fixed Width Filter -->
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg border border-gray-200 p-5 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Jobs</h3>
                    
                    <form method="GET" action="{{ route('jobs.index') }}" class="space-y-5" id="filterForm">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-indigo-500"
                                   placeholder="Job title or company">
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                            <input type="text" name="location" value="{{ request('location') }}"
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-indigo-500"
                                   placeholder="City or remote">
                        </div>

                        <!-- Job Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                            <div class="space-y-1">
                                @foreach(['Full-time', 'Part-time', 'Contract', 'Internship', 'Remote', 'Temporary'] as $type)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="job_type[]" value="{{ $type }}" 
                                               {{ in_array($type, (array)request('job_type', [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 text-sm">
                                        <span class="ml-2 text-sm">{{ $type }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Experience -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Experience</label>
                            <div class="space-y-1">
                                @foreach(['Entry', 'Mid', 'Senior', 'Lead', 'Executive'] as $level)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="experience_level[]" value="{{ $level }}"
                                               {{ in_array($level, (array)request('experience_level', [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 text-sm">
                                        <span class="ml-2 text-sm">{{ $level }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Categories -->
                        @if($categories->count() > 0)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Categories</label>
                            <div class="space-y-1 ">
                                @foreach($categories as $category)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                               {{ in_array($category->id, (array)request('categories', [])) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 text-sm">
                                        <span class="ml-2 text-sm">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Salary -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Salary Range ($)</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="salary_min" value="{{ request('salary_min') }}"
                                       class="px-3 py-2 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-indigo-500"
                                       placeholder="Min">
                                <input type="number" name="salary_max" value="{{ request('salary_max') }}"
                                       class="px-3 py-2 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-indigo-500"
                                       placeholder="Max">
                            </div>
                        </div>

                        

                        <!-- Buttons -->
                        <div class="pt-3 border-t border-gray-200">
                            <button type="submit"
                                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded text-sm hover:bg-indigo-700 mb-2">
                                Apply Filters
                            </button>
                            <a href="{{ route('jobs.index') }}"
                               class="w-full block text-center bg-gray-100 text-gray-700 py-2 px-4 rounded text-sm hover:bg-gray-200">
                                Clear All
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side - Cards with smaller width -->
            <div class="flex-1 min-w-0">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-right mr-2 text-gray-900">Jobs Found: {{ $jobs->total() }} </h1>
                    <!-- @if($jobs->total() > 0)
                        <p class="text-gray-600 text-sm mt-1">Browse opportunities that match your skills</p>
                    @endif -->
                </div>

                @if ($jobs && $jobs->count() > 0)
                    <!-- Smaller Cards with 3 columns -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($jobs as $job)
                            <div class="bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow transition-all h-full flex flex-col">
                                <div class="p-4 flex-1 flex flex-col">
                                    <!-- Company & Title -->
                                    <div class="flex items-start gap-3 mb-3">
                                        @if ($job->company_logo)
                                            <img src="{{ asset('storage/' . $job->company_logo) }}" 
                                                 alt="{{ $job->company_name }}"
                                                 class="w-10 h-10 rounded-lg object-cover border border-gray-200 flex-shrink-0">
                                        @else
                                            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <span class="text-base font-bold text-indigo-600">
                                                    {{ substr($job->company_name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-900 text-bold text-sm mb-1 truncate" title="{{ $job->title }}">
                                                {{ $job->title }}
                                            </h3>
                                            <p class="text-xs text-gray-600 truncate" title="{{ $job->company_name }}">
                                                {{ $job->company_name }}
                                            </p>
                                        </div>
                                        @if($job->is_featured)
                                            <span class="text-xs font-semibold px-2 py-0.5 bg-green-100 text-green-800 rounded-full">
                                                Featured
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Details -->
                                    <div class="space-y-2 mb-3 flex-1">
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="truncate text-xs">{{ $job->location }}</span>
                                        </div>

                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="truncate text-xs">{{ $job->job_type }}</span>
                                        </div>

                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="truncate text-xs">
                                                @if($job->salary_min && $job->salary_max)
                                                    ${{ number_format($job->salary_min) }}-${{ number_format($job->salary_max) }}
                                                @elseif($job->salary)
                                                    {{ $job->salary }} {{ $job->salary_currency }}
                                                @else
                                                    Negotiable
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Tags & Button -->
                                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                        <div class="flex gap-1">
                                            <span class="text-xs px-2 py-0.5 bg-blue-50 text-blue-700 rounded">
                                                {{ $job->experience_level }}
                                            </span>
                                            <span class="text-xs px-2 py-0.5 bg-purple-50 text-purple-700 rounded">
                                                {{ $job->job_type }}
                                            </span>
                                        </div>
                                        <a href="{{ route('jobs.show', $job) }}" 
                                           class="text-xs font-medium text-indigo-600 hover:text-indigo-800 whitespace-nowrap">
                                            Details →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($jobs->hasPages())
                    <div class="mt-6">
                        {{ $jobs->withQueryString()->links() }}
                    </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-base font-semibold text-gray-900 mb-1">No jobs found</h3>
                        <!-- <p class="text-gray-600 text-sm mb-3">Try changing your filters</p> -->
                        <a href="{{ route('jobs.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            Clear all filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit on checkbox change
        document.querySelectorAll('#filterForm input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });

        // Auto-submit on salary input (with debounce)
        let salaryTimeout;
        document.querySelectorAll('#filterForm input[type="number"]').forEach(input => {
            input.addEventListener('change', function() {
                clearTimeout(salaryTimeout);
                salaryTimeout = setTimeout(() => {
                    this.closest('form').submit();
                }, 500);
            });
        });

        // Add tooltip for truncated text
        document.querySelectorAll('.truncate').forEach(element => {
            if (element.scrollWidth > element.clientWidth) {
                element.title = element.textContent;
            }
        });
    });
</script>
@endpush