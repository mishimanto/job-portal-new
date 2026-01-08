@extends('layouts.admin')

@section('title', 'Add Company - Admin Panel')
@section('page-title', 'Add Company')
@section('page-subtitle', 'Create a new company')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Company Details
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Fill in the company information below
        </p>
    </div>
    
    <form action="{{ route('admin.companies.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Company Name *
                </label>
                <input type="text" 
                       name="name" 
                       id="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address
                </label>
                <input type="email" 
                       name="email" 
                       id="email"
                       value="{{ old('email') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number
                </label>
                <input type="tel" 
                       name="phone" 
                       id="phone"
                       value="{{ old('phone') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                @error('phone')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Website -->
            <div>
                <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                    Website
                </label>
                <input type="url" 
                       name="website" 
                       id="website"
                       value="{{ old('website') }}"
                       placeholder="https://example.com"
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                @error('website')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Industry -->
            <div>
                <label for="industry" class="block text-sm font-medium text-gray-700 mb-2">
                    Industry
                </label>
                <input type="text" 
                       name="industry" 
                       id="industry"
                       value="{{ old('industry') }}"
                       placeholder="e.g., Technology, Healthcare"
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                @error('industry')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                    Location
                </label>
                <input type="text" 
                       name="location" 
                       id="location"
                       value="{{ old('location') }}"
                       placeholder="e.g., New York, NY"
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                @error('location')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Size -->
            <div>
                <label for="size" class="block text-sm font-medium text-gray-700 mb-2">
                    Company Size
                </label>
                <input type="number" 
                       name="size" 
                       id="size"
                       value="{{ old('size') }}"
                       placeholder="e.g., 100"
                       min="1"
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                @error('size')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Founded Date -->
            <div>
                <label for="founded_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Founded Date
                </label>
                <input type="date" 
                       name="founded_date" 
                       id="founded_date"
                       value="{{ old('founded_date') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                @error('founded_date')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Company Description
            </label>
            <textarea name="description" 
                      id="description"
                      rows="4"
                      class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Logo Upload -->
        <div>
    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
        Company Logo
    </label>
    <div class="flex items-center space-x-4">
        <div class="flex-shrink-0">
            <div id="logoPreview" class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center border-2 border-gray-300 border-dashed">
                <span class="text-gray-400 text-xs">No logo</span>
            </div>
        </div>
        <div class="flex-1">
            <input type="file" 
                   name="logo" 
                   id="logo"
                   accept="image/*"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                   onchange="previewLogo(event)">
            <p class="mt-1 text-xs text-gray-500">
                Maximum file size: 2MB. Supported formats: JPG, PNG, GIF
            </p>
            @error('logo')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>


        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('admin.companies.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200">
                Create Company
            </button>
        </div>
    </form>
</div>

<script>
function previewLogo(event) {
    const input = event.target;
    const preview = document.getElementById('logoPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="h-16 w-16 object-cover rounded-lg" alt="Logo preview">`;
            preview.classList.remove('border-dashed');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection