<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     */
    public function index()
    {
        return $this->getBlogsData();
    }

    /**
     * AJAX filter route for live filtering
     */
    public function filter(Request $request)
    {
        return $this->getBlogsData(true);
    }

    /**
     * Get blogs data with filtering, sorting, and pagination
     */
    private function getBlogsData($isAjax = false)
    {
        try {
            $query = Blog::published()->with('author');
            
            // Search functionality
            $search = request('search');
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%")
                      ->orWhere('author_name', 'like', "%{$search}%");
                });
            }
            
            // Category filter
            $category = request('category');
            if ($category) {
                $query->where('category', $category);
            }
            
            // Sorting
            $sort = request('sort', 'newest');
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('published_at', 'asc');
                    break;
                case 'views':
                    $query->orderBy('views', 'desc');
                    break;
                case 'featured':
                    $query->orderBy('is_featured', 'desc')->orderBy('published_at', 'desc');
                    break;
                default: // 'newest'
                    $query->orderBy('published_at', 'desc');
                    break;
            }
            
            // Pagination
            $blogs = $query->paginate(12)->withQueryString();
            
            // Get featured blogs (apply same filters)
            $featuredQuery = Blog::published()->where('is_featured', true);
            
            if ($search) {
                $featuredQuery->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%");
                });
            }
            
            if ($category) {
                $featuredQuery->where('category', $category);
            }
            
            $featuredBlogs = $featuredQuery->orderBy('published_at', 'desc')->take(4)->get();
            
            // Get categories with counts (considering current filters)
            $categoriesQuery = Blog::published();
            
            if ($search) {
                $categoriesQuery->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%");
                });
            }
            
            $categories = $categoriesQuery->select('category')
                ->whereNotNull('category')
                ->groupBy('category')
                ->orderByRaw('COUNT(*) DESC')
                ->pluck('category');
            
            // Get popular blogs (considering current filters)
            $popularQuery = Blog::published();
            
            if ($search) {
                $popularQuery->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%");
                });
            }
            
            if ($category) {
                $popularQuery->where('category', $category);
            }
            
            $popularBlogs = $popularQuery->orderBy('views', 'desc')->take(5)->get();
            
            // Get totals
            $totalBlogs = Blog::published()->count();
            $totalViews = Blog::published()->sum('views');
            
            // If AJAX request, return JSON response
            if (request()->ajax() || $isAjax) {
                return response()->json([
                    'success' => true,
                    'blogsHtml' => view('blogs.partials.list', compact('blogs'))->render(),
                    'featuredHtml' => view('blogs.partials.featured', compact('featuredBlogs'))->render(),
                    'popularHtml' => view('blogs.partials.popular', compact('popularBlogs'))->render(),
                    'categoriesHtml' => view('blogs.partials.categories', compact('categories'))->render(),
                    'stats' => [
                        'totalBlogs' => $totalBlogs,
                        'totalCategories' => $categories->count(),
                        'totalFeatured' => $featuredBlogs->count(),
                        'totalViews' => $totalViews
                    ],
                    'pagination' => [
                        'current_page' => $blogs->currentPage(),
                        'last_page' => $blogs->lastPage(),
                        'per_page' => $blogs->perPage(),
                        'total' => $blogs->total()
                    ]
                ]);
            }
            
            // Regular request - return full view
            return view('blogs.index', compact(
                'blogs',
                'featuredBlogs',
                'categories',
                'popularBlogs',
                'totalBlogs',
                'totalViews'
            ));
            
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('BlogController error: ' . $e->getMessage());
            
            // Return error response for AJAX
            if (request()->ajax() || $isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while loading blogs. Please try again.'
                ], 500);
            }
            
            // For regular request, throw the exception
            throw $e;
        }
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        
        // Check if blog is published
        if (!$blog->is_published || ($blog->published_at && $blog->published_at->isFuture())) {
            abort(404);
        }
        
        // Increment view count
        $blog->incrementViews();
        
        // Get related posts
        $relatedBlogs = $this->getRelatedBlogs($blog);
            
        return view('blogs.show', compact('blog', 'relatedBlogs'));
    }
    
    /**
     * Get related blog posts
     */
    private function getRelatedBlogs($blog)
    {
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where(function ($query) use ($blog) {
                // Match by category
                if ($blog->category) {
                    $query->where('category', $blog->category);
                }
                
                // Match by tags
                if ($blog->tags && is_array($blog->tags) && count($blog->tags) > 0) {
                    $query->orWhere(function ($q) use ($blog) {
                        foreach ($blog->tags as $tag) {
                            $q->orWhereJsonContains('tags', $tag);
                        }
                    });
                }
            })
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
            
        // If no related posts found, get recent posts instead
        if ($relatedBlogs->count() === 0) {
            $relatedBlogs = Blog::published()
                ->where('id', '!=', $blog->id)
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get();
        }
            
        return $relatedBlogs;
    }
}