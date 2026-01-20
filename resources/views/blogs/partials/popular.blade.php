@if($popularBlogs && $popularBlogs->count() > 0)
<div class="space-y-4">
    @foreach($popularBlogs as $index => $blog)
    <div class="flex items-start space-x-3 group">
        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-gradient-to-br from-[#1C4D8D] to-[#4988C4] flex items-center justify-center text-white text-sm font-bold">
            {{ $index + 1 }}
        </div>
        <div class="flex-1 min-w-0">
            <a href="{{ route('blogs.show', $blog->slug) }}" 
               class="text-sm font-medium text-gray-800 hover:text-[#1C4D8D] line-clamp-2 mb-1 transition-colors">
                {{ $blog->title }}
            </a>
            <div class="flex items-center text-xs text-gray-500">
                <span>{{ $blog->published_at ? $blog->published_at->format('M d') : '' }}</span>
                <span class="mx-2">•</span>
                <span class="flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ $blog->views }}
                </span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif