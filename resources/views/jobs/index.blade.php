@extends('layouts.app')

@section('title', 'Careers | Join Our Team')

@section('content')
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if ($jobs && $jobs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($jobs as $job)
                    <x-card class="job-card hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    @if ($job->company_logo)
                                        <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company_name }}"
                                            class="w-14 h-14 rounded-xl object-cover border border-gray-200">
                                    @else
                                        <div
                                            class="w-14 h-14 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                            <span
                                                class="text-2xl font-bold text-indigo-600">{{ substr($job->company_name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-900">{{ $job->title }}</h3>
                                        <p class="text-gray-600">{{ $job->company_name }}</p>
                                    </div>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                    Featured
                                </span>
                            </div>

                            <div class="space-y-3 mb-6">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $job->location }}</span>
                                </div>

                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ ucfirst($job->job_type) }}</span>
                                </div>

                                @if ($job->salary)
                                    <div class="flex items-center text-gray-600">
                                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">{{ $job->experience_level }}</span>
                                    <span
                                        class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full">{{ $job->job_type }}</span>
                                </div>
                                <a href="{{ route('jobs.show', $job) }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                                    Apply Now →
                                </a>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Featured Jobs Available</h3>
                <p class="text-gray-600">Check back soon for new opportunities!</p>
            </div>
        @endif

    </section>
@endsection
