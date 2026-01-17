<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Filter Jobs</h3>
    
    <form method="GET" action="{{ route('jobs.index') }}" class="space-y-6">
        <!-- Search Input -->
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Keywords</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Job title, keywords, or company">
        </div>

        <!-- Location -->
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
            <input type="text" name="location" id="location" value="{{ request('location') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="City, State, or Remote">
        </div>

        <!-- Job Type Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Job Type</label>
            <div class="space-y-2">
                @foreach(['Full-time', 'Part-time', 'Contract', 'Internship', 'Remote', 'Temporary'] as $type)
                    <label class="flex items-center">
                        <input type="checkbox" name="job_type[]" value="{{ $type }}" 
                               {{ in_array($type, (array)request('job_type', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">{{ $type }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Experience Level -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Experience Level</label>
            <div class="space-y-2">
                @foreach(['Entry', 'Mid', 'Senior', 'Lead', 'Executive'] as $level)
                    <label class="flex items-center">
                        <input type="checkbox" name="experience_level[]" value="{{ $level }}"
                               {{ in_array($level, (array)request('experience_level', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">{{ $level }} Level</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Salary Range -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-2">Min Salary ($)</label>
                <input type="number" name="salary_min" id="salary_min" value="{{ request('salary_min') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="0">
            </div>
            <div>
                <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-2">Max Salary ($)</label>
                <input type="number" name="salary_max" id="salary_max" value="{{ request('salary_max') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="500000">
            </div>
        </div>

        <!-- Categories -->
        @if($categories->count() > 0)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
            <div class="space-y-2 max-h-40 overflow-y-auto">
                @foreach($categories as $category)
                    <label class="flex items-center">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                               {{ in_array($category->id, (array)request('categories', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Filter Actions -->
        <div class="flex space-x-4 pt-4 border-t border-gray-200">
            <button type="submit"
                    class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                Apply Filters
            </button>
            <a href="{{ route('jobs.index') }}"
               class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors text-center">
                Clear All
            </a>
        </div>
    </form>
</div>