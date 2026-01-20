@if($categories && $categories->count() > 0)
<div class="space-y-2">
    @foreach($categories as $category)
    @php
        $categoryCount = App\Models\Blog::published()
            ->when(request('search'), function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%");
                });
            })
            ->where('category', $category)
            ->count();
    @endphp
    <button type="button" 
            onclick="filterByCategory('{{ $category }}')"
            class="w-full text-left flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition-colors group category-filter-btn"
            data-category="{{ $category }}">
        <span class="text-gray-700 group-hover:text-blue-700">
            {{ $category }}
        </span>
        <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600 group-hover:bg-[#1C4D8D]/10 group-hover:text-blue-700">
            {{ $categoryCount }}
        </span>
    </button>
    @endforeach
</div>
@else
<p class="text-gray-500 text-sm">No categories available</p>
@endif