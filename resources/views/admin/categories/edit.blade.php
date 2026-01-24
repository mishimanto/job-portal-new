@extends('layouts.admin')

@section('title', 'Edit ' . $category->name . ' - Admin Panel')
@section('page-title', 'Edit Category')
@section('page-subtitle', 'Update category information')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- <div class="px-6 py-5 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Edit Category
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Update category details
                </p>
            </div>
            @if($category->icon)
                <div class="text-2xl">{{ $category->icon }}</div>
            @endif
        </div>
    </div> -->
    
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                Category Name *
            </label>
            <input type="text" 
                   name="name" 
                   id="name"
                   value="{{ old('name', $category->name) }}"
                   required
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                   placeholder="e.g., Information Technology">
            @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Description
            </label>
            <textarea name="description" 
                      id="description"
                      rows="3"
                      class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                      placeholder="Describe this category...">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Icon -->
        <div>
            <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                Icon (Optional)
            </label>
            <input type="text" 
                   name="icon" 
                   id="icon"
                   value="{{ old('icon', $category->icon) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                   placeholder="e.g., 💼 (Emoji) or fas fa-briefcase (FontAwesome)">
            <p class="mt-1 text-xs text-gray-500">
                You can use emojis or FontAwesome class names
            </p>
            @error('icon')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order -->
            <!-- <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                    Display Order
                </label>
                <input type="number" 
                       name="order" 
                       id="order"
                       value="{{ old('order', $category->order) }}"
                       min="0"
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                @error('order')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div> -->

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Status
                </label>
                <div class="flex items-center">
                    <label class="inline-flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               @checked(old('is_active', $category->is_active))
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-600">Active</span>
                    </label>
                </div>
                @error('is_active')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <!-- <div class="flex items-center space-x-4">
                <a href="{{ route('admin.categories.show', $category) }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors duration-200">
                    View Category
                </a>
            </div> -->
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.categories.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors duration-200">
                    Update Category
                </button>
            </div>
        </div>
    </form>
</div>
@endsection