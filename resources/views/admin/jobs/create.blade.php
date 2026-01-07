@extends('layouts.admin')

@section('title', 'Post New Job - Admin Panel')
@section('page-title', 'Post New Job')
@section('page-subtitle', 'Create a new job posting')

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
        <span class="ml-4 text-sm font-medium text-gray-500">
            Post New Job
        </span>
    </div>
</li>
@endsection

@section('content')
<div class="space-y-6">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Job Details
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Fill in the details to create a new job posting
            </p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('admin.jobs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-8">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h4 class="text-lg font-medium text-gray-900">Basic Information</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">
                                    Job Title *
                                </label>
                                <input type="text" name="title" id="title" 
                                       value="{{ old('title') }}"
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
                                       value="{{ old('company_name') }}"
                                       required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('company_name')
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
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
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
                                       value="{{ old('location') }}"
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
                                       value="{{ old('salary') }}"
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
                                    <option value="full-time" {{ old('job_type') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                    <option value="part-time" {{ old('job_type') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                    <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="remote" {{ old('job_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                                    <option value="internship" {{ old('job_type') == 'internship' ? 'selected' : '' }}>Internship</option>
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
                                    <option value="intern" {{ old('experience_level') == 'intern' ? 'selected' : '' }}>Intern</option>
                                    <option value="junior" {{ old('experience_level') == 'junior' ? 'selected' : '' }}>Junior (0-2 years)</option>
                                    <option value="mid" {{ old('experience_level') == 'mid' ? 'selected' : '' }}>Mid Level (2-5 years)</option>
                                    <option value="senior" {{ old('experience_level') == 'senior' ? 'selected' : '' }}>Senior (5+ years)</option>
                                    <option value="lead" {{ old('experience_level') == 'lead' ? 'selected' : '' }}>Lead/Manager</option>
                                    <option value="executive" {{ old('experience_level') == 'executive' ? 'selected' : '' }}>Executive</option>
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
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('skills_required') }}</textarea>
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
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('benefits') }}</textarea>
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
                                       value="{{ old('application_deadline') }}"
                                       min="{{ date('Y-m-d') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('application_deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="company_logo" class="block text-sm font-medium text-gray-700">
                                    Company Logo
                                </label>
                                <input type="file" name="company_logo" id="company_logo" 
                                       accept="image/*"
                                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('company_logo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="is_active" class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <span class="ml-2 text-sm text-gray-700">Active Job Posting</span>
                                </label>
                                <p class="mt-1 text-sm text-gray-500">
                                    If checked, the job will be visible to job seekers
                                </p>
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">
                                    Status
                                </label>
                                <select name="status" id="status"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">
                                    Set job status. Admin jobs are usually auto-approved.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.jobs.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Post Job
                            </button>
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
            let preview = document.getElementById('preview-image');
            if (!preview) {
                preview = document.createElement('img');
                preview.id = 'preview-image';
                preview.className = 'mt-2 rounded-lg shadow-sm';
                document.getElementById('company_logo').parentNode.appendChild(preview);
            }
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

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
</script>
@endpush
@endsection