@extends('layouts.admin')

@section('title', 'Edit ' . $job->title . ' - Admin Panel')
@section('page-title', 'Edit Job')
@section('page-subtitle', 'Update job posting details')

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
        <a href="{{ route('admin.jobs.show', $job) }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
            {{ Str::limit($job->title, 20) }}
        </a>
    </div>
</li>
<li>
    <div class="flex items-center">
        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
        </svg>
        <span class="ml-4 text-sm font-medium text-gray-500">
            Edit
        </span>
    </div>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Edit Job: {{ $job->title }}
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Update the details to modify this job posting
            </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.jobs.update', $job) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-8">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h4 class="text-lg font-medium text-gray-900">Basic Information</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">
                                    Job Title *
                                </label>
                                <input type="text" name="title" id="title" 
                                       value="{{ old('title', $job->title) }}"
                                       required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700">
                                    Company Name *
                                </label>
                                <input type="text" name="company_name" id="company_name" 
                                       value="{{ old('company_name', $job->company_name) }}"
                                       required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('company_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700">
                                    Category *
                                </label>
                                <select name="category_id" id="category_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                            @if($category->icon)
                                                - {{ $category->icon }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Job Description *
                            </label>
                            <textarea name="description" id="description" rows="6"
                                      required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $job->description) }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Job Details -->
                    <div class="space-y-6">
                        <h4 class="text-lg font-medium text-gray-900">Job Details</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">
                                    Location *
                                </label>
                                <input type="text" name="location" id="location" 
                                       value="{{ old('location', $job->location) }}"
                                       required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="salary" class="block text-sm font-medium text-gray-700">
                                    Salary (per year)
                                </label>
                                <input type="number" name="salary" id="salary" 
                                       value="{{ old('salary', $job->salary) }}"
                                       min="0" step="0.01"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('salary')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="job_type" class="block text-sm font-medium text-gray-700">
                                    Job Type *
                                </label>
                                <select name="job_type" id="job_type" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Select Job Type</option>
                                    <option value="full-time" {{ old('job_type', $job->job_type) == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="part-time" {{ old('job_type', $job->job_type) == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="contract" {{ old('job_type', $job->job_type) == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="remote" {{ old('job_type', $job->job_type) == 'remote' ? 'selected' : '' }}>Remote</option>
                                    <option value="internship" {{ old('job_type', $job->job_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                                </select>
                                @error('job_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="experience_level" class="block text-sm font-medium text-gray-700">
                                    Experience Level *
                                </label>
                                <select name="experience_level" id="experience_level" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Select Experience Level</option>
                                    <option value="intern" {{ old('experience_level', $job->experience_level) == 'intern' ? 'selected' : '' }}>Intern</option>
                                    <option value="junior" {{ old('experience_level', $job->experience_level) == 'junior' ? 'selected' : '' }}>Junior (0-2 years)</option>
                                    <option value="mid" {{ old('experience_level', $job->experience_level) == 'mid' ? 'selected' : '' }}>Mid Level (2-5 years)</option>
                                    <option value="senior" {{ old('experience_level', $job->experience_level) == 'senior' ? 'selected' : '' }}>Senior (5+ years)</option>
                                    <option value="lead" {{ old('experience_level', $job->experience_level) == 'lead' ? 'selected' : '' }}>Lead/Manager</option>
                                    <option value="executive" {{ old('experience_level', $job->experience_level) == 'executive' ? 'selected' : '' }}>Executive</option>
                                </select>
                                @error('experience_level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Requirements & Benefits -->
                    <div class="space-y-6">
                        <h4 class="text-lg font-medium text-gray-900">Requirements & Benefits</h4>
                        
                        <div>
                            <label for="skills_required" class="block text-sm font-medium text-gray-700">
                                Skills Required (Comma separated)
                            </label>
                            <textarea name="skills_required" id="skills_required" rows="3"
                                      placeholder="e.g., JavaScript, PHP, Laravel, React, Vue.js"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('skills_required', is_array($job->skills_required) ? implode(', ', $job->skills_required) : $job->skills_required) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">
                                Enter skills separated by commas
                            </p>
                            @error('skills_required')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="benefits" class="block text-sm font-medium text-gray-700">
                                Benefits (One per line)
                            </label>
                            <textarea name="benefits" id="benefits" rows="4"
                                      placeholder="e.g., Health Insurance&#10;Paid Time Off&#10;Remote Work Options&#10;Professional Development"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('benefits', is_array($job->benefits) ? implode("\n", $job->benefits) : $job->benefits) }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">
                                Enter each benefit on a new line
                            </p>
                            @error('benefits')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="space-y-6">
                        <h4 class="text-lg font-medium text-gray-900">Additional Information</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="application_deadline" class="block text-sm font-medium text-gray-700">
                                    Application Deadline
                                </label>
                                <input type="date" name="application_deadline" id="application_deadline" 
                                       value="{{ old('application_deadline', $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}"
                                       min="{{ date('Y-m-d') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('application_deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Logo Upload Section -->
                            <div>
                                <label for="company_logo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Logo
                                </label>
                                
                                <!-- Current Logo Preview -->
                                @if($job->company_logo)
                                    <div class="mb-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ Storage::url($job->company_logo) }}" 
                                                     alt="{{ $job->company_name }}"
                                                     class="h-12 w-12 rounded-lg object-cover">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Current Logo</p>
                                                    <p class="text-xs text-gray-500">Upload new to replace</p>
                                                </div>
                                            </div>
                                            <button type="button" 
                                                    onclick="removeCurrentLogo()"
                                                    class="text-sm text-red-600 hover:text-red-800 font-medium">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- File Upload -->
                                <input type="file" name="company_logo" id="company_logo" 
                                       accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                
                                <!-- New Logo Preview -->
                                <div id="logo-preview" class="hidden mt-3 p-3 bg-indigo-50 rounded-lg border border-indigo-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <img id="preview-image" class="h-12 w-12 rounded-lg object-cover border border-gray-300" 
                                                 src="" alt="Logo preview">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">New Logo Preview</p>
                                                <p class="text-xs text-gray-500">Will replace current logo</p>
                                            </div>
                                        </div>
                                        <button type="button" 
                                                onclick="removeLogoPreview()"
                                                class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Hidden field for logo removal -->
                                <input type="hidden" name="remove_logo" id="remove_logo" value="0">
                                
                                @error('company_logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="is_active" class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                                           {{ old('is_active', $job->is_active) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Active Job Posting</span>
                                </label>
                                <p class="mt-1 text-sm text-gray-500">
                                    If checked, the job will be visible to job seekers
                                </p>
                                @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">
                                    Status
                                </label>
                                <select name="status" id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="pending" {{ old('status', $job->status) == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                    <option value="approved" {{ old('status', $job->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status', $job->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">
                                    Set job status. Changing status may affect visibility.
                                </p>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex justify-between">
                            <div class="text-sm text-gray-500">
                                <p>Created: {{ $job->created_at->format('M d, Y h:i A') }}</p>
                                <p>Last updated: {{ $job->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('admin.jobs.show', $job) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Update Job
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Custom styles for the form */
#preview-image {
    max-width: 200px;
    max-height: 200px;
}
</style>
@endpush

@push('scripts')
<script>
// Preview image before upload
document.getElementById('company_logo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-image');
            const logoPreview = document.getElementById('logo-preview');
            
            if (preview) {
                preview.src = e.target.result;
                logoPreview.classList.remove('hidden');
            }
        }
        reader.readAsDataURL(file);
    }
});

// Remove logo preview
function removeLogoPreview() {
    const input = document.getElementById('company_logo');
    const logoPreview = document.getElementById('logo-preview');
    
    input.value = '';
    logoPreview.classList.add('hidden');
}

// Remove current logo
function removeCurrentLogo() {
    if (confirm('Are you sure you want to remove the current logo?')) {
        document.getElementById('remove_logo').value = '1';
        // Hide the current logo display
        const logoContainer = document.querySelector('[for="company_logo"]').closest('div').querySelector('.bg-gray-50');
        if (logoContainer) {
            logoContainer.remove();
        }
    }
}

// Auto-format skills input
document.getElementById('skills_required').addEventListener('blur', function(e) {
    const skills = this.value.split(',').map(skill => skill.trim()).filter(skill => skill);
    this.value = skills.join(', ');
});

// Auto-format benefits input
document.getElementById('benefits').addEventListener('blur', function(e) {
    const benefits = this.value.split('\n').map(benefit => benefit.trim()).filter(benefit => benefit);
    this.value = benefits.join('\n');
});

// Update is_active based on status selection
document.getElementById('status').addEventListener('change', function(e) {
    const isActiveCheckbox = document.getElementById('is_active');
    if (this.value === 'approved') {
        isActiveCheckbox.checked = true;
    } else if (this.value === 'rejected') {
        isActiveCheckbox.checked = false;
    }
});
</script>
@endpush
@endsection