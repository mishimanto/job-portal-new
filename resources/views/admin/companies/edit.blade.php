@extends('layouts.admin')

@section('title', 'Edit ' . $company->name . ' - Admin Panel')
@section('page-title', 'Edit Company')
@section('page-subtitle', 'Update company information')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Edit Company
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Update company details and information
                </p>
            </div>
            <div class="flex items-center space-x-3">
                @if($company->logo)
                    <img src="{{ Storage::url($company->logo) }}" 
                         alt="{{ $company->name }}"
                         class="h-10 w-10 rounded-full object-cover">
                @endif
            </div>
        </div>
    </div>
    
    <form action="{{ route('admin.companies.update', $company) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Company Name *
                </label>
                <input type="text" 
                       name="name" 
                       id="name"
                       value="{{ old('name', $company->name) }}"
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
                       value="{{ old('email', $company->email) }}"
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
                       value="{{ old('phone', $company->phone) }}"
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
                       value="{{ old('website', $company->website) }}"
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
                       value="{{ old('industry', $company->industry) }}"
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
                       value="{{ old('location', $company->location) }}"
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
                       value="{{ old('size', $company->size) }}"
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
                       value="{{ old('founded_date', $company->founded_date) }}"
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
                      class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">{{ old('description', $company->description) }}</textarea>
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
            @if($company->logo)
                <div id="logoPreview" class="h-16 w-16 rounded-lg border border-gray-300 overflow-hidden">
                    <img src="{{ Storage::url($company->logo) }}" 
                         class="h-16 w-16 object-cover" 
                         alt="Current logo">
                </div>
            @else
                <div id="logoPreview" class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center border-2 border-gray-300 border-dashed">
                    <span class="text-gray-400 text-xs">No logo</span>
                </div>
            @endif
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
            <p class="mt-1 text-xs text-gray-500">
                Leave empty to keep current logo
            </p>
            @error('logo')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

        <!-- Account Status -->
        <div class="pt-6 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Status</h3>
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <h3 class="text-sm font-medium text-gray-900">Company Active</h3>
                    <p class="text-sm text-gray-500">Enable or disable company account</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           @if(old('is_active', $company->is_active)) checked @endif
                           class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                </label>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.companies.show', $company) }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">
                    View Company
                </a>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.companies.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200">
                    Update Company
                </button>
            </div>
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