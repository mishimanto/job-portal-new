@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Edit Blog Post
                </h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('admin.blogs.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <div class="mt-5 md:mt-0">
            <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" id="blogForm" novalidate>
                @csrf
                @method('PUT')
                
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        @if($errors->any())
                        <div class="rounded-md bg-red-50 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="rounded-md bg-green-50 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">{{ session('success') }}</h3>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Post Title <span class="text-lg text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title', $blog->title) }}"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <div id="titleError" class="text-red-500 text-sm mt-1 hidden">Title is required</div>
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-gray-700">
                                Excerpt (Short Summary)
                            </label>
                            <textarea id="excerpt" 
                                      name="excerpt" 
                                      rows="3"
                                      class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('excerpt', $blog->excerpt) }}</textarea>
                            <div class="flex justify-between mt-1">
                                <p class="text-sm text-gray-500">
                                    Brief summary of your post
                                </p>
                                <div id="excerptCharCount" class="text-xs text-gray-500">
                                    {{ strlen(old('excerpt', $blog->excerpt)) }}/500
                                </div>
                            </div>
                        </div>

                        <!-- Content with CKEditor -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Content <span class="text-lg text-red-500">*</span>
                            </label>
                            <div class="border border-gray-300 rounded-md overflow-hidden">
                                <textarea id="content" 
                                          name="content" 
                                          rows="15"
                                          class="hidden">{!! old('content', $blog->content) !!}</textarea>
                                <div id="editor-container">
                                    <div id="editor">{!! old('content', $blog->content) !!}</div>
                                </div>
                            </div>
                            <div id="contentError" class="text-red-500 text-sm mt-1 hidden">
                                Content is required (minimum 10 characters)
                            </div>
                        </div>

                        <!-- Featured Image Section -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Featured Image
                            </label>
                            
                            <div class="mt-1 relative" id="imageUploadContainer">
                                <!-- Hidden input for remove current image -->
                                <input type="hidden" name="remove_current_image" id="removeCurrentImageInput" value="0">
                                
                                <!-- Current Image Preview (Only if image exists) -->
                                @if($blog->featured_image)
                                <div id="currentImagePreviewContainer" class="mb-4">
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 flex items-center justify-center">
                                        <div class="flex items-center justify-between mb-3">
                                            <!-- <div>
                                                <p class="text-sm font-medium text-gray-900">Current Image</p>
                                                <p class="text-xs text-gray-500">Upload new image to replace</p>
                                            </div> -->
                                            
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <div class="flex flex-col items-center gap-3 text-center">
                                                <img id="currentImagePreview" 
                                                    src="{{ asset('storage/' . $blog->featured_image) }}" 
                                                    alt="{{ $blog->title }}" 
                                                    class="h-32 w-32 object-cover rounded-md shadow-md border border-gray-300">

                                                <a href="javascript:void(0)" 
                                                id="removeCurrentImageBtn"
                                                class="text-sm text-red-600 font-medium underline underline-offset-4
                                                        hover:text-red-700 transition-colors">
                                                    Remove current image
                                                </a>
                                            </div>

                                            <!-- <div class="flex-1">
                                                <button type="button" 
                                                        id="showUploadAreaBtn"
                                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                    </svg>
                                                    Upload New Image
                                                </button>
                                                <p class="text-xs text-gray-500 mt-2">Click to upload a new image</p>
                                            </div> -->
                                            
                                        </div>

                                        
                                    </div>
                                </div>
                                @endif

                                <!-- New Image Upload Area -->
                                <div id="newImageUploadContainer" class="{{ $blog->featured_image ? 'hidden' : '' }}">
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors duration-200" id="dropArea">
                                        <!-- New Image Preview -->
                                        <div id="newImagePreviewContainer" class="hidden mb-4">
                                            <div class="relative inline-block">
                                                <img id="newImagePreview" 
                                                     src="" 
                                                     alt="New image preview" 
                                                     class="mx-auto h-40 w-auto rounded-lg object-cover shadow-md border border-gray-300">
                                                <button type="button" 
                                                        id="removeNewImageBtn"
                                                        class="absolute -top-2 -right-2 inline-flex items-center p-1.5 border border-red-300 rounded-full text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-2">New image will replace current image</p>
                                        </div>
                                        
                                        <!-- Upload Instructions -->
                                        <div id="uploadInstructions">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 justify-center mt-4">
                                                <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload an image</span>
                                                    <input id="featured_image" 
                                                           name="featured_image" 
                                                           type="file" 
                                                           accept="image/*"
                                                           class="sr-only">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2">
                                                PNG, JPG, GIF, WebP up to 2MB
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Back to Current Image Button (Only shown when current image exists) -->
                                    @if($blog->featured_image)
                                    <div id="backToCurrentImageContainer" class="hidden mt-4 text-center">
                                        <button type="button" 
                                                id="backToCurrentImageBtn"
                                                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                            </svg>
                                            Back to Current Image
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Category & Tags Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">
                                    Category
                                </label>
                                <select id="category" 
                                        name="category"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select Category</option>
                                    <option value="Career Tips" {{ old('category', $blog->category) == 'Career Tips' ? 'selected' : '' }}>Career Tips</option>
                                    <option value="Interview Tips" {{ old('category', $blog->category) == 'Interview Tips' ? 'selected' : '' }}>Interview Tips</option>
                                    <option value="Resume Writing" {{ old('category', $blog->category) == 'Resume Writing' ? 'selected' : '' }}>Resume Writing</option>
                                    <option value="Industry News" {{ old('category', $blog->category) == 'Industry News' ? 'selected' : '' }}>Industry News</option>
                                    <option value="Success Stories" {{ old('category', $blog->category) == 'Success Stories' ? 'selected' : '' }}>Success Stories</option>
                                    <option value="Workplace Tips" {{ old('category', $blog->category) == 'Workplace Tips' ? 'selected' : '' }}>Workplace Tips</option>
                                    <option value="Remote Work" {{ old('category', $blog->category) == 'Remote Work' ? 'selected' : '' }}>Remote Work</option>
                                    <option value="Job Search" {{ old('category', $blog->category) == 'Job Search' ? 'selected' : '' }}>Job Search</option>
                                    <option value="Skill Development" {{ old('category', $blog->category) == 'Skill Development' ? 'selected' : '' }}>Skill Development</option>
                                </select>
                            </div>

                            <!-- Tags -->
                            <div>
                                <label for="tags" class="block text-sm font-medium text-gray-700">
                                    Tags
                                </label>
                                @php
                                    $tagsValue = '';
                                    if ($blog->tags && is_array($blog->tags)) {
                                        $tagsValue = implode(', ', $blog->tags);
                                    } elseif ($blog->tags) {
                                        $decodedTags = json_decode($blog->tags, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedTags)) {
                                            $tagsValue = implode(', ', $decodedTags);
                                        } else {
                                            $tagsValue = $blog->tags;
                                        }
                                    }
                                @endphp
                                <input type="text" 
                                    name="tags" 
                                    id="tags" 
                                    value="{{ old('tags', $tagsValue) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="career, job-search, interview, resume">
                                <p class="mt-2 text-sm text-gray-500">
                                    Separate tags with commas
                                </p>
                            </div>
                        </div>

                        <!-- Author Name & Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Author Name -->
                            <div>
                                <label for="author_name" class="block text-sm font-medium text-gray-700">
                                    Author Name
                                </label>
                                <input type="text" 
                                       name="author_name" 
                                       id="author_name" 
                                       value="{{ old('author_name', $blog->author_name) }}"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Status -->
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input id="is_published" 
                                           name="is_published" 
                                           type="checkbox" 
                                           value="1"
                                           {{ old('is_published', $blog->is_published) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                        Published
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input id="is_featured" 
                                           name="is_featured" 
                                           type="checkbox" 
                                           value="1"
                                           {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                        Mark as featured
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Published At -->
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700">
                                Publish Date
                            </label>
                            <input type="datetime-local" 
                                   name="published_at" 
                                   id="published_at" 
                                   value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <p class="mt-2 text-sm text-gray-500">
                                Leave empty to use current date
                            </p>
                        </div>

                        <!-- SEO Section -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Settings</h3>
                            
                            <div class="space-y-4">
                                <!-- Meta Title -->
                                <div>
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700">
                                        Meta Title
                                    </label>
                                    <input type="text" 
                                           name="meta_title" 
                                           id="meta_title" 
                                           value="{{ old('meta_title', $blog->meta_title) }}"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <p class="mt-2 text-sm text-gray-500">
                                        Title for search engines (optional)
                                    </p>
                                </div>

                                <!-- Meta Description -->
                                <div>
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700">
                                        Meta Description
                                    </label>
                                    <textarea id="meta_description" 
                                              name="meta_description" 
                                              rows="3"
                                              class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Brief description for search engines (optional)
                                    </p>
                                </div>

                                <!-- Meta Keywords -->
                                <div>
                                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700">
                                        Meta Keywords
                                    </label>
                                    <input type="text" 
                                           name="meta_keywords" 
                                           id="meta_keywords" 
                                           value="{{ old('meta_keywords', $blog->meta_keywords) }}"
                                           class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                           placeholder="job, career, employment, tips">
                                    <p class="mt-2 text-sm text-gray-500">
                                        Comma-separated keywords (optional)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('admin.blogs.index') }}"
                           class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                id="submitBtn"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span id="submitText">Update Post</span>
                            <svg id="submitSpinner" class="hidden animate-spin ml-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .ck-editor__editable {
        min-height: 400px;
        max-height: 600px;
        overflow-y: auto;
    }
    
    .ck.ck-editor {
        border: 1px solid #e5e7eb !important;
        border-radius: 0.375rem;
        transition: border-color 0.2s;
    }
    
    .ck.ck-toolbar {
        border: none !important;
        border-bottom: 1px solid #e5e7eb !important;
        background-color: #f9fafb !important;
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
    
    .ck.ck-editor__main>.ck-editor__editable {
        border: none !important;
        border-top: 1px solid #e5e7eb !important;
    }
    
    .ck.ck-toolbar .ck.ck-toolbar__separator {
        background-color: #e5e7eb !important;
    }
    
    .drag-over {
        background-color: #f3f4f6;
        border-color: #6366f1;
        border-style: solid;
    }
    
    .error {
        border-color: #f87171 !important;
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<!-- CKEditor from CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image Upload Functionality
    const fileInput = document.getElementById('featured_image');
    const dropArea = document.getElementById('dropArea');
    const newImagePreview = document.getElementById('newImagePreview');
    const newImagePreviewContainer = document.getElementById('newImagePreviewContainer');
    const uploadInstructions = document.getElementById('uploadInstructions');
    const removeNewImageBtn = document.getElementById('removeNewImageBtn');
    const removeCurrentImageBtn = document.getElementById('removeCurrentImageBtn');
    const showUploadAreaBtn = document.getElementById('showUploadAreaBtn');
    const backToCurrentImageBtn = document.getElementById('backToCurrentImageBtn');
    const backToCurrentImageContainer = document.getElementById('backToCurrentImageContainer');
    const currentImagePreviewContainer = document.getElementById('currentImagePreviewContainer');
    const newImageUploadContainer = document.getElementById('newImageUploadContainer');
    const removeCurrentImageInput = document.getElementById('removeCurrentImageInput');
    const currentImagePreview = document.getElementById('currentImagePreview');
    
    // Function to show notification
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white transform transition-all duration-300 ${
            type === 'error' ? 'bg-red-500' : 
            type === 'success' ? 'bg-green-500' : 'bg-blue-500'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                        type === 'error' ? 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' :
                        type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' :
                        'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    }"/>
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }
    
    // Function to preview new image
    function previewNewImage(file) {
        if (!file) return;
        
        // Check file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            showNotification('File size must be less than 2MB', 'error');
            fileInput.value = '';
            return;
        }
        
        // Check file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            showNotification('Please upload a valid image file (JPEG, PNG, GIF, WebP)', 'error');
            fileInput.value = '';
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            newImagePreview.src = e.target.result;
            newImagePreviewContainer.classList.remove('hidden');
            uploadInstructions.classList.add('hidden');
        }
        
        reader.readAsDataURL(file);
    }
    
    // Function to remove new image preview
    function removeNewImagePreview() {
        newImagePreviewContainer.classList.add('hidden');
        uploadInstructions.classList.remove('hidden');
        fileInput.value = '';
        newImagePreview.src = '';
    }
    
    // Function to remove current image
    function removeCurrentImage() {
        if (removeCurrentImageInput) {
            removeCurrentImageInput.value = '1';
        }
        
        // Mark current image as removed
        if (currentImagePreview) {
            currentImagePreview.style.opacity = '0.5';
            currentImagePreview.style.filter = 'grayscale(100%)';
        }
        
        // Show only upload area
        if (currentImagePreviewContainer) {
            currentImagePreviewContainer.classList.add('hidden');
        }
        
        if (newImageUploadContainer) {
            newImageUploadContainer.classList.remove('hidden');
        }
        
        showNotification('Current image will be removed. You can upload a new image.', 'info');
    }
    
    // Function to show upload new image mode
    function showUploadNewImageMode() {
        if (currentImagePreviewContainer) {
            currentImagePreviewContainer.classList.add('hidden');
        }
        
        if (newImageUploadContainer) {
            newImageUploadContainer.classList.remove('hidden');
        }
        
        if (backToCurrentImageContainer) {
            backToCurrentImageContainer.classList.remove('hidden');
        }
    }
    
    // Function to show current image mode
    function showCurrentImageMode() {
        if (currentImagePreviewContainer) {
            currentImagePreviewContainer.classList.remove('hidden');
        }
        
        if (newImageUploadContainer) {
            newImageUploadContainer.classList.add('hidden');
        }
        
        if (backToCurrentImageContainer) {
            backToCurrentImageContainer.classList.add('hidden');
        }
        
        // Clear new image preview
        removeNewImagePreview();
    }
    
    // Event Listeners
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                previewNewImage(this.files[0]);
            }
        });
    }
    
    if (removeNewImageBtn) {
        removeNewImageBtn.addEventListener('click', removeNewImagePreview);
    }
    
    if (removeCurrentImageBtn) {
        removeCurrentImageBtn.addEventListener('click', removeCurrentImage);
    }
    
    if (showUploadAreaBtn) {
        showUploadAreaBtn.addEventListener('click', showUploadNewImageMode);
    }
    
    if (backToCurrentImageBtn) {
        backToCurrentImageBtn.addEventListener('click', showCurrentImageMode);
    }
    
    // Drag and Drop functionality
    if (dropArea) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.classList.add('drag-over');
        }
        
        function unhighlight() {
            dropArea.classList.remove('drag-over');
        }
        
        dropArea.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                if (fileInput) {
                    fileInput.files = files;
                    previewNewImage(files[0]);
                }
            }
            
            unhighlight();
        });
        
        // Click to select file
        dropArea.addEventListener('click', function(e) {
            if (e.target !== fileInput && !e.target.closest('label')) {
                fileInput.click();
            }
        });
    }
    
    // CKEditor initialization
    let editor;
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [
                'heading',
                '|',
                'bold', 'italic',
                '|',
                'link',
                'bulletedList', 'numberedList',
                '|',
                'blockQuote',
                '|',
                'undo', 'redo'
            ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                ]
            },
            placeholder: 'Write your blog content here...',
            language: 'en',
            removePlugins: [
                'CKFinder',
                'EasyImage',
                'Image',
                'ImageCaption',
                'ImageStyle',
                'ImageToolbar',
                'ImageUpload',
                'MediaEmbed',
                'Table',
                'TableToolbar',
                'TableProperties',
                'TableCellProperties'
            ],
        })
        .then(editorInstance => {
            editor = editorInstance;
            
            // Clear content error when user starts typing
            editor.model.document.on('change:data', () => {
                const content = editor.getData().trim();
                const contentError = document.getElementById('contentError');
                
                if (content.length >= 10) {
                    if (contentError) contentError.classList.add('hidden');
                    editor.ui.view.editable.element.classList.remove('error');
                }
            });
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
            const editorContainer = document.getElementById('editor-container');
            if (editorContainer) {
                editorContainer.innerHTML = `
                    <div class="p-4 bg-red-50 text-red-700 rounded-md">
                        <p class="font-medium">CKEditor failed to load</p>
                        <p class="text-sm mt-1">Please use the textarea below to enter your content.</p>
                    </div>
                `;
                const contentTextarea = document.getElementById('content');
                if (contentTextarea) contentTextarea.classList.remove('hidden');
            }
        });
    
    // Form validation and submission
    const form = document.getElementById('blogForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!validateForm()) {
                return false;
            }
            
            // Sync CKEditor data with hidden textarea
            if (editor) {
                const contentTextarea = document.getElementById('content');
                if (contentTextarea) {
                    contentTextarea.value = editor.getData();
                }
            }
            
            // Show loading state
            if (submitBtn && submitText && submitSpinner) {
                submitBtn.disabled = true;
                submitText.textContent = 'Updating...';
                submitSpinner.classList.remove('hidden');
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            }
            
            this.submit();
            return true;
        });
    }
    
    function validateForm() {
        let isValid = true;
        
        // Validate title
        const title = document.getElementById('title')?.value.trim();
        const titleError = document.getElementById('titleError');
        if (!title) {
            if (titleError) titleError.classList.remove('hidden');
            const titleInput = document.getElementById('title');
            if (titleInput) {
                titleInput.classList.add('error');
                titleInput.focus();
            }
            showNotification('Please enter a title', 'error');
            isValid = false;
        } else {
            if (titleError) titleError.classList.add('hidden');
            const titleInput = document.getElementById('title');
            if (titleInput) titleInput.classList.remove('error');
        }
        
        // Validate content
        let content = '';
        const contentError = document.getElementById('contentError');
        
        if (editor) {
            content = editor.getData().trim();
        } else {
            content = document.getElementById('content')?.value.trim() || '';
        }
        
        if (!content || content.length < 10) {
            if (contentError) contentError.classList.remove('hidden');
            if (editor) {
                editor.ui.view.editable.element.classList.add('error');
                editor.focus();
            } else {
                const contentInput = document.getElementById('content');
                if (contentInput) {
                    contentInput.classList.add('error');
                    contentInput.focus();
                }
            }
            showNotification('Please enter content (minimum 10 characters)', 'error');
            isValid = false;
        } else {
            if (contentError) contentError.classList.add('hidden');
            if (editor) {
                editor.ui.view.editable.element.classList.remove('error');
            } else {
                const contentInput = document.getElementById('content');
                if (contentInput) contentInput.classList.remove('error');
            }
        }
        
        return isValid;
    }
    
    // Character counter for excerpt
    const excerptTextarea = document.getElementById('excerpt');
    const charCount = document.getElementById('excerptCharCount');
    
    if (excerptTextarea && charCount) {
        function updateCharCount() {
            const length = excerptTextarea.value.length;
            charCount.textContent = `${length}/500 characters`;
            
            if (length > 500) {
                charCount.classList.add('text-red-500');
                charCount.classList.remove('text-gray-500');
                excerptTextarea.classList.add('border-red-300');
            } else {
                charCount.classList.remove('text-red-500');
                charCount.classList.add('text-gray-500');
                excerptTextarea.classList.remove('border-red-300');
            }
        }
        
        excerptTextarea.addEventListener('input', updateCharCount);
        
        // Auto-expand excerpt textarea
        excerptTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});
</script>
@endpush