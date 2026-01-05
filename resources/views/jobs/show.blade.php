@extends('layouts.app')

@section('title', "{$job->title} | Join Our Team")

@section('content')
<section class="max-w-7xl mx-auto p-6 bg-white rounded-xl shadow-lg space-y-6 mt-10">

    <!-- Job Header -->
    <div class="flex items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <img src="{{ $job->company_logo ?? 'default.png' }}" alt="{{ $job->company_name }}" class="w-16 h-16 rounded-lg">
            <div>
                <h1 class="text-2xl font-bold">{{ $job->title }}</h1>
                <p class="text-gray-600">{{ $job->company_name }}</p>
                <p class="text-pink-600 font-medium">Application Deadline: {{ $job->application_deadline->format('d M Y') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('jobs.apply', $job->id) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Apply Now</a>
            <!-- Add Shortlist / Share buttons here -->
        </div>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-4" aria-label="Tabs">
            <button class="tab-button text-indigo-600 border-b-2 border-indigo-600 px-3 py-2 font-medium text-sm">All</button>
            <button class="tab-button text-gray-500 hover:text-indigo-600 px-3 py-2 font-medium text-sm">Requirements</button>
            <button class="tab-button text-gray-500 hover:text-indigo-600 px-3 py-2 font-medium text-sm">Responsibilities</button>
            <button class="tab-button text-gray-500 hover:text-indigo-600 px-3 py-2 font-medium text-sm">Company Info</button>
        </nav>
    </div>

    <!-- Tab Panels -->
    <div class="tab-content space-y-6">
        <div class="tab-panel">
            <!-- Summary -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg">
                <div><span class="font-semibold">Vacancy:</span> {{ $job->vacancy ?? 'N/A' }}</div>
                <div><span class="font-semibold">Age:</span> 25 to 40 years</div>
                <div><span class="font-semibold">Location:</span> {{ $job->location }}</div>
                <div><span class="font-semibold">Salary:</span> {{ $job->salary ?? 'Negotiable' }}</div>
            </div>
        </div>

        <div class="tab-panel hidden">
            <!-- Requirements -->
            <h3 class="font-semibold text-lg">Education</h3>
            <p>B.Sc / Diploma in Civil Engineering</p>

            <h3 class="font-semibold text-lg mt-4">Experience</h3>
            <p>5 to 10 years</p>

            <h3 class="font-semibold text-lg mt-4">Additional Requirements</h3>
            <p>Age 25 to 40 years</p>
        </div>

        <div class="tab-panel hidden">
            <!-- Responsibilities -->
            <ul class="list-disc pl-5 space-y-2">
                <li>Strong capability of project management & manpower management.</li>
                <li>Sound knowledge on all kinds of design & drawing.</li>
                <li>Vast knowledge on construction works including finishing works.</li>
                <li>Strong interpersonal & communication skills.</li>
                <li>Excellence time management & leadership skills.</li>
            </ul>
        </div>

        <div class="tab-panel hidden">
            <!-- Company Info -->
            <p>{{ $job->company_info ?? 'Information not available' }}</p>
        </div>
    </div>
</section>

@endsection
