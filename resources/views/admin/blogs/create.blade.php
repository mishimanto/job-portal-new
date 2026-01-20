@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Create New Blog Post
                </h2>
                <!-- <p class="mt-1 text-sm text-gray-500">
                    Fill in the details below to create a new blog post.
                </p> -->
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('admin.blogs.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <div class="mt-5 md:mt-0">
            <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
                @csrf
                
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

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Post Title <span class="text-lg text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}"
                                   required
                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                                      class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('excerpt') }}</textarea>
                            <div class="flex justify-between mt-1">
                                <p class="text-sm text-gray-500">
                                    Brief summary of your post
                                </p>
                                <div id="excerptCharCount" class="text-xs text-gray-500">0/500</div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Content <span class="text-lg text-red-500">*</span>
                            </label>
                            <!-- Hidden textarea for form submission -->
                            <textarea id="content" 
                                      name="content" 
                                      class="hidden">{!! old('content') !!}</textarea>
                            
                            <!-- CKEditor container -->
                            <div id="editor-container">
                                <textarea id="ckeditor">{!! old('content') !!}</textarea>
                            </div>
                            
                            <div id="contentError" class="text-red-500 text-sm mt-1 hidden">
                                Content is required (minimum 10 characters)
                            </div>
                        </div>

                        <!-- Image Upload with Preview -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Featured Image
                            </label>
                            
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative" id="dropArea">
                                <div class="space-y-1 text-center w-full">
                                    <!-- Image Preview Container -->
                                    <div id="imagePreviewContainer" class="hidden mb-4">
                                        <img id="imagePreview" 
                                             src="" 
                                             alt="Image preview" 
                                             class="mx-auto h-32 w-auto rounded-lg object-cover shadow-md">
                                        <button type="button" 
                                                onclick="removePreview()"
                                                class="mt-2 inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Remove Image
                                        </button>
                                    </div>
                                    
                                    <!-- Upload Area (Shown when no preview) -->
                                    <div id="uploadArea">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="featured_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
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
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">Select Category</option>
                                    <option value="Career Tips" {{ old('category') == 'Career Tips' ? 'selected' : '' }}>Career Tips</option>
                                    <option value="Interview Tips" {{ old('category') == 'Interview Tips' ? 'selected' : '' }}>Interview Tips</option>
                                    <option value="Resume Writing" {{ old('category') == 'Resume Writing' ? 'selected' : '' }}>Resume Writing</option>
                                    <option value="Industry News" {{ old('category') == 'Industry News' ? 'selected' : '' }}>Industry News</option>
                                    <option value="Success Stories" {{ old('category') == 'Success Stories' ? 'selected' : '' }}>Success Stories</option>
                                    <option value="Workplace Tips" {{ old('category') == 'Workplace Tips' ? 'selected' : '' }}>Workplace Tips</option>
                                    <option value="Remote Work" {{ old('category') == 'Remote Work' ? 'selected' : '' }}>Remote Work</option>
                                    <option value="Job Search" {{ old('category') == 'Job Search' ? 'selected' : '' }}>Job Search</option>
                                    <option value="Skill Development" {{ old('category') == 'Skill Development' ? 'selected' : '' }}>Skill Development</option>
                                </select>
                            </div>

                            <!-- Tags -->
                            <div>
                                <label for="tags" class="block text-sm font-medium text-gray-700">
                                    Tags
                                </label>
                                <input type="text" 
                                       name="tags" 
                                       id="tags" 
                                       value="{{ old('tags') }}"
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
                                       value="{{ old('author_name', auth()->user()->name) }}"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Status -->
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input id="is_published" 
                                           name="is_published" 
                                           type="checkbox" 
                                           value="1"
                                           {{ old('is_published', true) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                        Publish immediately
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input id="is_featured" 
                                           name="is_featured" 
                                           type="checkbox" 
                                           value="1"
                                           {{ old('is_featured') ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
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
                                   value="{{ old('published_at') }}"
                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                                           value="{{ old('meta_title') }}"
                                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                                              class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('meta_description') }}</textarea>
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
                                           value="{{ old('meta_keywords') }}"
                                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                           class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                id="submitBtn"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span id="submitText">Create Post</span>
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
    /* CKEditor Custom Styling */
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
    
    /* Image Preview Styling */
    #imagePreview {
        max-height: 200px;
        max-width: 100%;
        object-fit: contain;
    }
    
    .drag-over {
        background-color: #f3f4f6;
        border-color: #6366f1;
    }
    
    .border-red-500 {
        border-color: #f87171 !important;
    }
    
    /* Loading spinner */
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
        let editor;
        const form = document.getElementById('blogForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');
        
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#ckeditor'), {
                toolbar: [
                    'heading',
                    '|',
                    'bold', 'italic', 'underline', 'strikethrough',
                    '|',
                    'link', 'bulletedList', 'numberedList',
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
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                },
                placeholder: 'Write your blog content here...',
            })
            .then(editorInstance => {
                editor = editorInstance;
                console.log('CKEditor initialized successfully');
                
                // Auto-save content to hidden textarea
                editor.model.document.on('change:data', () => {
                    const content = editor.getData();
                    document.getElementById('content').value = content;
                });
                
                // Set initial value
                const initialContent = document.getElementById('content').value;
                if (initialContent) {
                    editor.setData(initialContent);
                }
            })
            .catch(error => {
                console.error('CKEditor initialization error:', error);
                alert('CKEditor failed to load. Please refresh the page.');
            });

        // Image Preview Functions
        function previewImage(input) {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');
            const uploadArea = document.getElementById('uploadArea');
            const file = input.files[0];
            
            if (file) {
                // Check file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('File size must be less than 2MB', 'error');
                    input.value = '';
                    return;
                }
                
                // Check file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    showNotification('Please upload a valid image file (JPEG, PNG, GIF, WebP)', 'error');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    uploadArea.classList.add('hidden');
                }
                
                reader.readAsDataURL(file);
            }
        }

        function removePreview() {
            const previewContainer = document.getElementById('imagePreviewContainer');
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('featured_image');
            
            previewContainer.classList.add('hidden');
            uploadArea.classList.remove('hidden');
            fileInput.value = '';
            document.getElementById('imagePreview').src = '';
        }

        // Drag and Drop Functionality
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('featured_image');
        
        if (dropArea && fileInput) {
            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            // Highlight drop area when item is dragged over it
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
            
            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    fileInput.files = files;
                    previewImage(fileInput);
                }
                
                unhighlight();
            }
            
            // Click to select file
            dropArea.addEventListener('click', function(e) {
                if (e.target !== fileInput && !e.target.closest('label')) {
                    fileInput.click();
                }
            });
            
            // File input change event
            fileInput.addEventListener('change', function() {
                previewImage(this);
            });
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
                    excerptTextarea.classList.add('border-red-500');
                } else {
                    charCount.classList.remove('text-red-500');
                    charCount.classList.add('text-gray-500');
                    excerptTextarea.classList.remove('border-red-500');
                }
            }
            
            excerptTextarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
            
            // Auto-expand excerpt textarea
            excerptTextarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }

        // Form validation
        function validateForm() {
            let isValid = true;
            
            // Validate title
            const title = document.getElementById('title').value.trim();
            const titleError = document.getElementById('titleError');
            if (!title) {
                titleError.classList.remove('hidden');
                document.getElementById('title').classList.add('border-red-500');
                document.getElementById('title').focus();
                showNotification('Please enter a title', 'error');
                isValid = false;
            } else {
                titleError.classList.add('hidden');
                document.getElementById('title').classList.remove('border-red-500');
            }
            
            // Validate content
            let content = '';
            const contentError = document.getElementById('contentError');
            
            if (editor) {
                content = editor.getData();
                // Ensure content is saved to hidden textarea
                document.getElementById('content').value = content;
            } else {
                content = document.getElementById('content').value;
            }
            
            // Strip HTML tags and check text length
            const strippedContent = content.replace(/<[^>]*>/g, '').trim();
            
            if (!strippedContent || strippedContent.length < 10) {
                contentError.classList.remove('hidden');
                if (editor) {
                    editor.ui.view.editable.element.classList.add('border-red-500');
                    editor.focus();
                }
                if (isValid) {
                    showNotification('Please enter content (minimum 10 characters)', 'error');
                }
                isValid = false;
            } else {
                contentError.classList.add('hidden');
                if (editor) {
                    editor.ui.view.editable.element.classList.remove('border-red-500');
                }
            }
            
            return isValid;
        }

        // Form submission handler
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                console.log('Form submission started...');
                
                // Ensure CKEditor content is saved
                if (editor) {
                    const content = editor.getData();
                    document.getElementById('content').value = content;
                    console.log('Content saved from CKEditor, length:', content.length);
                }
                
                // Validate form
                if (!validateForm()) {
                    console.log('Form validation failed');
                    return false;
                }
                
                console.log('Form validation passed');
                
                // Show loading state
                if (submitBtn && submitText && submitSpinner) {
                    submitBtn.disabled = true;
                    submitText.textContent = 'Creating...';
                    submitSpinner.classList.remove('hidden');
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                }
                
                // Submit the form
                console.log('Submitting form...');
                this.submit();
            });
        }
        
        // Real-time validation on blur
        const titleInput = document.getElementById('title');
        if (titleInput) {
            titleInput.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.classList.add('border-red-500');
                    document.getElementById('titleError').classList.remove('hidden');
                } else {
                    this.classList.remove('border-red-500');
                    document.getElementById('titleError').classList.add('hidden');
                }
            });
        }
        
        // Show notification function
        function showNotification(message, type = 'info') {
            // Create notification element
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
            
            // Add to page
            document.body.appendChild(notification);
            
            // Remove after 5 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 5000);
        }
        
        // Make functions globally available
        window.previewImage = previewImage;
        window.removePreview = removePreview;
        window.showNotification = showNotification;
    });
</script>
@endpush