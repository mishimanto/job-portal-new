@if($blogs && $blogs->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
    @foreach($blogs as $blog)
    <div class="group bg-white border border-gray-200  hover:border-[#1C4D8D]/30 hover:shadow-lg transition-all duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-[#BDE8F5] to-[#E3F7FF] text-[#1C4D8D]">
                    {{ $blog->category ?? 'Career Tips' }}
                </span>
                @if($blog->is_featured)
                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Featured
                </span>
                @endif
            </div>
            
            <h3 class="text-lg font-bold text-gray-800 mb-3 group-hover:text-[#1C4D8D] transition-colors line-clamp-2">
                <a href="{{ route('blogs.show', $blog->slug) }}">
                    {{ $blog->title }}
                </a>
            </h3>
            
            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 120) }}
            </p>
            
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $blog->published_at ? $blog->published_at->format('M d') : 'Draft' }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ $blog->views }}
                    </span>
                    <span>{{ $blog->reading_time ?? 1 }} min read</span>
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

<!-- Pagination -->
<div class="mt-8 pt-6 border-t border-gray-100">
    {{ $blogs->links() }}
</div>
@else
<div class="text-center py-12">
    <div class="w-24 h-24 mx-auto mb-6 text-gray-300">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
    </div>
    <h3 class="text-xl font-medium text-gray-900 mb-2">No articles found</h3>
    <p class="text-gray-600 max-w-md mx-auto mb-6">
        @if(request()->has('search') || request()->has('category'))
            Try adjusting your search or filter to find what you're looking for.
        @else
            No blog posts available at the moment. Check back soon for new content!
        @endif
    </p>
</div>
@endif