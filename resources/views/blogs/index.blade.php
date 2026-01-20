@extends('layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<!-- Hero Section - Clean Design -->
<section class="relative bg-white">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                Career Insights & 
                <span class="text-blue-700">Professional Growth</span>
            </h1>
            <!-- <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                Expert advice, industry trends, and career development tips to boost your professional journey.
            </p> -->
            
            <!-- Search Bar - Minimal -->
            <div class="max-w-xl mx-auto">
                <div class="relative">
                    <input type="text" 
                           id="searchInput"
                           placeholder="Search articles, tips, and guides..." 
                           class="w-full px-5 py-3.5 rounded-lg border border-gray-300 text-gray-800 focus:outline-none focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/20 transition-all duration-200">
                    <button type="button" 
                            onclick="filterBlogs()"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-700 transition-colors p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats - Clean Cards -->
<!-- <section class="py-8 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['id' => 'totalBlogs', 'count' => $totalBlogs ?? 0, 'label' => 'Total Articles', 'bg' => 'bg-white'],
                ['id' => 'totalCategories', 'count' => $categories->count() ?? 0, 'label' => 'Categories', 'bg' => 'bg-white'],
                ['id' => 'totalFeatured', 'count' => $featuredBlogs->count() ?? 0, 'label' => 'Featured', 'bg' => 'bg-white'],
                ['id' => 'totalViews', 'count' => $totalViews ?? 0, 'label' => 'Total Views', 'bg' => 'bg-white']
            ] as $stat)
            <div class="{{ $stat['bg'] }} rounded-lg p-4 text-center border border-gray-100 hover:border-[#1C4D8D]/20 transition-colors duration-200">
                <div class="text-2xl font-bold text-blue-700 mb-1" id="{{ $stat['id'] }}">{{ $stat['count'] }}</div>
                <div class="text-sm text-gray-600">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section> -->

<!-- Blog Content -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Active Filters - Minimal -->
                <div id="filterSection" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200 hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm text-gray-600 font-medium">Active filters:</span>
                            <span id="activeFilters"></span>
                        </div>
                        <button type="button" 
                                onclick="clearFilters()"
                                class="text-sm text-gray-500 hover:text-gray-700 font-medium flex items-center gap-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear all
                        </button>
                    </div>
                </div>

                <!-- Featured Blogs -->
                <div id="featuredSection" class="mb-10">
                    @include('blogs.partials.featured')
                </div>

                <!-- All Blogs with Sorting -->
                <div class="bg-white rounded-xl">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 ">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">Latest Career Articles</h2>
                            <!-- <p class="text-gray-600 mt-1 text-sm">Browse our collection of professional development content</p> -->
                        </div>
                        
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            <span class="text-sm text-gray-600">Sort by:</span>
                            <div class="relative">
                                <select id="sortSelect" 
                                        onchange="filterBlogs()"
                                        class="appearance-none bg-white border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-2 focus:ring-[#1C4D8D]/20 focus:border-[#1C4D8D] block w-full px-3 py-2 pr-8 transition-colors">
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="views">Most Viewed</option>
                                    <option value="featured">Featured First</option>
                                </select>
                                <!-- <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- Blog List Container -->
                    <div id="blogsContainer">
                        @include('blogs.partials.list')
                    </div>
                </div>
            </div>

            <!-- Sidebar - Clean Design -->
            <div class="lg:w-1/4">
                <div class="sticky top-6 space-y-6">
                    <!-- Categories Widget -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Browse Categories
                        </h3>
                        <div class="space-y-1" id="categoriesList">
                            @foreach($categories as $category)
                            @php
                                $categoryCount = App\Models\Blog::published()
                                    ->where('category', $category)
                                    ->count();
                            @endphp
                            <button type="button" 
                                    onclick="filterByCategory('{{ $category }}')"
                                    class="w-full text-left flex items-center justify-between p-2.5 rounded-lg hover:bg-gray-50 transition-colors duration-150 category-filter-btn"
                                    data-category="{{ $category }}">
                                <span class="text-sm text-gray-700 hover:text-blue-700">
                                    {{ $category }}
                                </span>
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600 min-w-[24px] text-center">
                                    {{ $categoryCount }}
                                </span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Popular Posts -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <h3 class="text-base font-semibold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Trending Now
                        </h3>
                        <div id="popularPosts">
                            @include('blogs.partials.popular')
                        </div>
                    </div>

                    <!-- Newsletter CTA -->
                    <!-- <div class="bg-gradient-to-r from-[#1C4D8D] to-[#2D5F9E] rounded-xl p-5">
                        <div class="text-white mb-4">
                            <h3 class="font-semibold mb-2">Stay Updated</h3>
                            <p class="text-sm opacity-90">
                                Get career tips and insights delivered to your inbox
                            </p>
                        </div>
                        <form class="space-y-3">
                            <input type="email" 
                                   placeholder="Enter your email" 
                                   class="w-full px-4 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-white/30">
                            <button type="submit" 
                                    class="w-full bg-white text-blue-700 hover:bg-gray-100 py-2 rounded-lg font-medium text-sm transition-colors duration-200">
                                Subscribe
                            </button>
                        </form>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Loading Spinner - Clean -->
<div id="loadingSpinner" class="fixed inset-0 bg-white/90 flex items-center justify-center z-50 hidden">
    <div class="text-center">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-[3px] border-gray-300 border-t-[#1C4D8D] mb-3"></div>
        <p class="text-gray-600 text-sm">Loading content...</p>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Clean Design Improvements */
    body {
        font-feature-settings: "kern" 1, "liga" 1, "calt" 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Card hover effects */
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-2px);
    }

    /* Active category button */
    .category-filter-btn.active {
        background-color: rgba(28, 77, 141, 0.08);
        border-left: 3px solid #1C4D8D;
    }

    /* Smooth focus styles */
    input:focus, select:focus, button:focus {
        outline: none;
        ring-width: 2px;
    }

    /* Better border radius consistency */
    .rounded-sm { border-radius: 0.25rem; }
    .rounded { border-radius: 0.375rem; }
    .rounded-lg { border-radius: 0.5rem; }
    .rounded-xl { border-radius: 0.75rem; }

    /* Typography improvements */
    .text-display {
        font-size: 2.5rem;
        line-height: 1.2;
        letter-spacing: -0.02em;
    }

    @media (min-width: 768px) {
        .text-display {
            font-size: 3rem;
        }
    }

    /* Subtle animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }
</style>
@endpush

@push('scripts')
<script>
    // Current filter state - NO LOGIC CHANGES
    let currentFilters = {
        search: '',
        category: '',
        sort: 'newest',
        page: 1
    };

    // Initialize on page load - NO LOGIC CHANGES
    document.addEventListener('DOMContentLoaded', function() {
        // Get initial filters from URL
        const urlParams = new URLSearchParams(window.location.search);
        currentFilters.search = urlParams.get('search') || '';
        currentFilters.category = urlParams.get('category') || '';
        currentFilters.sort = urlParams.get('sort') || 'newest';
        currentFilters.page = parseInt(urlParams.get('page')) || 1;

        // Update UI with initial values
        document.getElementById('searchInput').value = currentFilters.search;
        document.getElementById('sortSelect').value = currentFilters.sort;
        
        // Update active category button
        updateCategoryButtons();
        updateFilterDisplay();
        
        // Set up search debounce
        setupSearchDebounce();
        
        // Attach pagination listeners
        attachPaginationListeners();
    });

    // Setup search with debounce - NO LOGIC CHANGES
    function setupSearchDebounce() {
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentFilters.search = e.target.value.trim();
                currentFilters.page = 1;
                filterBlogs();
            }, 500);
        });
    }

    // Filter blogs function - NO LOGIC CHANGES
    function filterBlogs() {
        currentFilters.sort = document.getElementById('sortSelect').value;
        currentFilters.page = 1;
        
        showLoading();
        updateUrl();
        fetchBlogs();
    }

    // Filter by category - NO LOGIC CHANGES
    function filterByCategory(category) {
        if (currentFilters.category === category) {
            currentFilters.category = '';
        } else {
            currentFilters.category = category;
        }
        
        currentFilters.page = 1;
        updateCategoryButtons();
        showLoading();
        updateUrl();
        fetchBlogs();
    }

    // Update category buttons UI - UPDATED FOR NEW DESIGN
    function updateCategoryButtons() {
        document.querySelectorAll('.category-filter-btn').forEach(btn => {
            const category = btn.getAttribute('data-category');
            if (currentFilters.category === category) {
                btn.classList.add('active');
                btn.querySelector('span:first-child').classList.add('font-medium', 'text-blue-700');
            } else {
                btn.classList.remove('active');
                btn.querySelector('span:first-child').classList.remove('font-medium', 'text-blue-700');
            }
        });
    }

    // Clear all filters - NO LOGIC CHANGES
    function clearFilters() {
        currentFilters = {
            search: '',
            category: '',
            sort: 'newest',
            page: 1
        };
        
        document.getElementById('searchInput').value = '';
        document.getElementById('sortSelect').value = 'newest';
        
        updateCategoryButtons();
        updateFilterDisplay();
        showLoading();
        updateUrl();
        fetchBlogs();
    }

    // Update filter display - UPDATED FOR NEW DESIGN
    function updateFilterDisplay() {
        const filterSection = document.getElementById('filterSection');
        const activeFilters = document.getElementById('activeFilters');
        
        let filters = [];
        
        if (currentFilters.search) {
            filters.push(`<span class="inline-flex items-center bg-white border border-gray-200 text-gray-700 px-3 py-1.5 rounded-full text-sm">
                Search: "${currentFilters.search}"
                <button type="button" onclick="clearSearch()" class="ml-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </span>`);
        }
        
        if (currentFilters.category) {
            filters.push(`<span class="inline-flex items-center bg-blue-50 text-blue-700 px-3 py-1.5 rounded-full text-sm border border-blue-100">
                ${currentFilters.category}
                <button type="button" onclick="clearCategory()" class="ml-2 text-blue-700/70 hover:text-blue-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </span>`);
        }
        
        if (filters.length > 0) {
            filterSection.classList.remove('hidden');
            activeFilters.innerHTML = filters.join(' ');
        } else {
            filterSection.classList.add('hidden');
        }
    }

    // Clear search only - NO LOGIC CHANGES
    function clearSearch() {
        currentFilters.search = '';
        document.getElementById('searchInput').value = '';
        currentFilters.page = 1;
        showLoading();
        updateUrl();
        fetchBlogs();
    }

    // Clear category only - NO LOGIC CHANGES
    function clearCategory() {
        currentFilters.category = '';
        updateCategoryButtons();
        currentFilters.page = 1;
        showLoading();
        updateUrl();
        fetchBlogs();
    }

    // Update URL without page reload - NO LOGIC CHANGES
    function updateUrl() {
        const params = new URLSearchParams();
        
        if (currentFilters.search) params.set('search', currentFilters.search);
        if (currentFilters.category) params.set('category', currentFilters.category);
        if (currentFilters.sort !== 'newest') params.set('sort', currentFilters.sort);
        if (currentFilters.page > 1) params.set('page', currentFilters.page);
        
        const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({}, '', newUrl);
    }

    // Fetch blogs via AJAX - NO LOGIC CHANGES
    function fetchBlogs() {
        const params = new URLSearchParams();
        
        if (currentFilters.search) params.append('search', currentFilters.search);
        if (currentFilters.category) params.append('category', currentFilters.category);
        if (currentFilters.sort) params.append('sort', currentFilters.sort);
        if (currentFilters.page > 1) params.append('page', currentFilters.page);
        
        fetch(`/blogs/filter?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update blogs container
                if (data.blogsHtml) {
                    document.getElementById('blogsContainer').innerHTML = data.blogsHtml;
                    // Reattach pagination event listeners
                    attachPaginationListeners();
                }
                
                // Update featured section
                if (data.featuredHtml) {
                    document.getElementById('featuredSection').innerHTML = data.featuredHtml;
                }
                
                // Update popular posts
                if (data.popularHtml) {
                    document.getElementById('popularPosts').innerHTML = data.popularHtml;
                }
                
                // Update categories
                if (data.categoriesHtml) {
                    document.getElementById('categoriesList').innerHTML = data.categoriesHtml;
                    // Reattach category listeners
                    attachCategoryListeners();
                }
                
                // Update stats - FIXED: Check if elements exist before updating
                if (data.stats) {
                    // Check for old element IDs
                    const totalBlogsEl = document.getElementById('totalBlogs');
                    const totalCategoriesEl = document.getElementById('totalCategories');
                    const totalFeaturedEl = document.getElementById('totalFeatured');
                    const totalViewsEl = document.getElementById('totalViews');
                    
                    // Update only if elements exist
                    if (totalBlogsEl) totalBlogsEl.textContent = data.stats.totalBlogs;
                    if (totalCategoriesEl) totalCategoriesEl.textContent = data.stats.totalCategories;
                    if (totalFeaturedEl) totalFeaturedEl.textContent = data.stats.totalFeatured;
                    if (totalViewsEl) totalViewsEl.textContent = data.stats.totalViews;
                    
                    // Alternative: Update using new IDs if you changed them
                    // Example if you changed to 'stats-total-blogs', 'stats-categories', etc.
                }
                
                updateFilterDisplay();
            } else {
                showError(data.message || 'Failed to load blogs');
            }
            
            hideLoading();
        })
        .catch(error => {
            console.error('Error:', error);
            showError('An error occurred while loading blogs');
            hideLoading();
        });
    }

    // Attach event listeners to category buttons - NO LOGIC CHANGES
    function attachCategoryListeners() {
        document.querySelectorAll('.category-filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                filterByCategory(category);
            });
        });
    }

    // Attach event listeners to pagination links - NO LOGIC CHANGES
    function attachPaginationListeners() {
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                currentFilters.page = url.searchParams.get('page') || 1;
                showLoading();
                fetchBlogs();
            });
        });
    }

    // Handle browser back/forward buttons - NO LOGIC CHANGES
    window.addEventListener('popstate', function() {
        const params = new URLSearchParams(window.location.search);
        currentFilters.search = params.get('search') || '';
        currentFilters.category = params.get('category') || '';
        currentFilters.sort = params.get('sort') || 'newest';
        currentFilters.page = parseInt(params.get('page')) || 1;
        
        document.getElementById('searchInput').value = currentFilters.search;
        document.getElementById('sortSelect').value = currentFilters.sort;
        updateCategoryButtons();
        
        showLoading();
        fetchBlogs();
    });

    // Show loading spinner - UPDATED FOR NEW DESIGN
    function showLoading() {
        document.getElementById('loadingSpinner').classList.remove('hidden');
    }

    // Hide loading spinner - UPDATED FOR NEW DESIGN
    function hideLoading() {
        document.getElementById('loadingSpinner').classList.add('hidden');
    }

    // Show error message - UPDATED FOR NEW DESIGN
    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 animate-fade-in';
        errorDiv.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm">${message}</span>
            </div>
        `;
        
        const container = document.getElementById('blogsContainer');
        if (container) {
            container.prepend(errorDiv);
            setTimeout(() => errorDiv.remove(), 5000);
        }
    }
</script>
@endpush