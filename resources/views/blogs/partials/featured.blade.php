@if($featuredBlogs && $featuredBlogs->count() > 0)
<div class="mb-12">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Featured Insights</h2>
            <!-- <p class="text-gray-600 mt-1">Handpicked articles for your professional growth</p> -->
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($featuredBlogs as $blog)
        <div class="bg-white shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 h-full">
            <div class="relative">
                <div class="h-64 overflow-hidden">
                    <img src="{{ $blog->featured_image ? Storage::url($blog->featured_image) : 'https://placehold.net/600x400.png' }}" 
                        alt="{{ $blog->title }}" 
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </div>
                @if($blog->featured_image)
                <div class="absolute top-4 left-4">
                    <span class="bg-blue text-white px-3 py-1 rounded-full text-xs font-bold">
                        Featured
                    </span>
                </div>
                @endif
            </div>

            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-3">
                    <span class="bg-[#BDE8F5]/20 text-blue px-3 py-1 rounded-full text-xs font-medium">
                        {{ $blog->category ?? 'Career Tips' }}
                    </span>
                    <span class="mx-3">•</span>
                    <span>{{ $blog->published_at ? $blog->published_at->format('M d, Y') : '' }}</span>
                    <span class="mx-3">•</span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $blog->views }}
                    </span>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3 leading-snug">
                    <a href="{{ route('blogs.show', $blog->slug) }}" class="hover:text-blue transition-colors">
                        {{ $blog->title }}
                    </a>
                </h3>
                <p class="text-gray-600 mb-4 line-clamp-3">
                    {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 150) }}
                </p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue/10 flex items-center justify-center mr-2">
                            <svg class="w-4 h-4 text-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600">{{ $blog->author_name }}</span>
                    </div>
                    <a href="{{ route('blogs.show', $blog->slug) }}" 
                        class="inline-flex items-center text-blue-600 font-medium group transition-all duration-300">
                        <span class="relative pb-1">
                            Read Article
                            <!-- underline effect -->
                            <span class="absolute left-0 bottom-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full"></span>
                        </span>
                        <!-- <svg class="w-4 h-4 ml-2 transition-transform duration-300 group-hover:translate-x-1" 
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg> -->
                    </a>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif