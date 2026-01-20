@extends('layouts.app')

@section('content')
<!-- Blog Content -->
<article class="py-12">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <span class=" text-[#1C4D8D] py-1 rounded-full text-xs font-bold">
                    {{ $blog->category ?? 'Career Tips' }}
                </span>
                <span class="mx-3">•</span>
                <span>{{ $blog->published_at ? $blog->published_at->format('F d, Y') : '' }}</span>
                <span class="mx-3">•</span>
                <span>{{ $blog->reading_time }} min read</span>
                <span class="mx-3">•</span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ $blog->views }} views
                </span>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $blog->title }}</h1>
            
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-[#1C4D8D] to-[#4988C4] flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($blog->author_name, 0, 1)) }}
                    </div>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $blog->author_name }}</p>
                    <p class="text-sm text-gray-500">Author</p>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        <div class="mb-8 overflow-hidden">
            <img 
                src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}" 
                alt="{{ $blog->title }}"
                class="w-full h-auto object-cover"
            >
        </div>

        <!-- Excerpt -->
        @if($blog->excerpt)
        <div class="bg-blue-50 border-l-4 border-[#1C4D8D] p-6 mb-8 rounded-r-lg">
            <p class="text-lg text-gray-800 italic">{{ $blog->excerpt }}</p>
        </div>
        @endif

        <!-- Content -->
        <div class="prose prose-lg max-w-none mb-12">
            {!! $blog->content !!}
        </div>

        <!-- Tags -->
        @if($blog->tags && count($blog->tags) > 0)
        <div class="mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-3">Tags</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($blog->tags as $tag)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800">
                    {{ $tag }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Share -->
        <div class="border-t border-b border-gray-200 py-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Share this article</h3>
                    <p class="text-gray-600">Help others discover these insights</p>
                </div>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                       target="_blank"
                       class="h-10 w-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                       target="_blank"
                       class="h-10 w-10 rounded-full bg-blue-400 text-white flex items-center justify-center hover:bg-blue-500">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                       target="_blank"
                       class="h-10 w-10 rounded-full bg-blue-700 text-white flex items-center justify-center hover:bg-blue-800">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode('Check out this article: ' . url()->current()) }}" 
                       class="h-10 w-10 rounded-full bg-gray-600 text-white flex items-center justify-center hover:bg-gray-700">
                        <i class="far fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Posts -->
        @if($relatedBlogs->count() > 0)
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Articles</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedBlogs as $related)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-40 overflow-hidden">
                        <img 
                            src="{{ $related->featured_image ? asset('storage/' . $related->featured_image) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" 
                            alt="{{ $related->title }}" 
                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                        >
                    </div>
                    <div class="p-5">
                        <div class="flex items-center text-xs text-gray-500 mb-2">
                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded">
                                {{ $related->category ?? 'General' }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                            <a href="{{ route('blogs.show', $related->slug) }}" class="hover:text-[#1C4D8D] transition-colors">
                                {{ $related->title }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-600 line-clamp-2 mb-3">
                            {{ $related->excerpt ?? Str::limit(strip_tags($related->content), 80) }}
                        </p>
                        <a href="{{ route('blogs.show', $related->slug) }}" 
                           class="text-sm text-[#1C4D8D] hover:text-[#4988C4] font-medium">
                            Read More →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Back to Blogs -->
        <div class="text-right">
            <a href="{{ route('blogs.index') }}" 
            class="inline-flex items-center text-blue-700 font-medium underline underline-offset-4
                    hover:text-blue-900 transition-colors">
                <!-- <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg> -->
                Back to All Articles
            </a>
        </div>

    </div>
</article>
@endsection

@push('styles')
<style>
.prose {
    color: #374151;
    line-height: 1.75;
}
.prose p {
    margin-top: 1.25em;
    margin-bottom: 1.25em;
}
.prose h2 {
    color: #111827;
    font-weight: 700;
    font-size: 1.875em;
    margin-top: 1.5em;
    margin-bottom: 0.75em;
    line-height: 1.3333333;
}
.prose h3 {
    color: #111827;
    font-weight: 600;
    font-size: 1.5em;
    margin-top: 1.3333333em;
    margin-bottom: 0.6666667em;
    line-height: 1.5;
}
.prose ul {
    list-style-type: disc;
    margin-top: 1.25em;
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}
.prose ol {
    list-style-type: decimal;
    margin-top: 1.25em;
    margin-bottom: 1.25em;
    padding-left: 1.625em;
}
.prose li {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}
.prose a {
    color: #1C4D8D;
    text-decoration: underline;
}
.prose a:hover {
    color: #4988C4;
}
</style>
@endpush