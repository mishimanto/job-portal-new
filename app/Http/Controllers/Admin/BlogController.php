<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);

        // Handle slug
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $validated['slug'] = $slug;
        
        // Handle tags - FIXED: Don't JSON encode, Laravel Model will handle it
        if ($request->has('tags') && !empty($request->tags)) {
            $tags = explode(',', $request->tags);
            $tags = array_map('trim', $tags);
            // Filter out empty tags
            $tags = array_filter($tags);
            // Store as array, Laravel will automatically cast to JSON
            $validated['tags'] = !empty($tags) ? array_values($tags) : null;
        } else {
            $validated['tags'] = null;
        }
        
        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blogs', 'public');
            $validated['featured_image'] = $path;
        }
        
        // Set author info
        $validated['author_id'] = auth()->id();
        if (empty($validated['author_name'])) {
            $validated['author_name'] = auth()->user()->name;
        }
        
        // Set published_at if not provided but is_published is true
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        // Create blog
        Blog::create($validated);
        
        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'published_at' => 'nullable|date',
        ]);
        
        // Handle slug if title changed
        if ($blog->title !== $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            
            while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $validated['slug'] = $slug;
        }
        
        // Handle tags - FIXED: Don't JSON encode, Laravel Model will handle it
        if ($request->has('tags') && !empty($request->tags)) {
            $tags = explode(',', $request->tags);
            $tags = array_map('trim', $tags);
            // Filter out empty tags
            $tags = array_filter($tags);
            // Store as array, Laravel will automatically cast to JSON
            $validated['tags'] = !empty($tags) ? array_values($tags) : null;
        } else {
            $validated['tags'] = null;
        }
        
        // Handle current image removal
        if ($request->has('remove_current_image') && $request->remove_current_image == '1') {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = null;
        }
        
        // Handle new featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            
            $path = $request->file('featured_image')->store('blogs', 'public');
            $validated['featured_image'] = $path;
        }
        
        // Update published_at if is_published changed to true
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }
        
        $blog->update($validated);
        
        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        // Delete featured image
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        
        $blog->delete();
        
        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully.');
    }
    
    public function toggleStatus(Blog $blog)
    {
        $blog->update([
            'is_published' => !$blog->is_published,
            'published_at' => $blog->is_published ? null : now()
        ]);
        
        return back()->with('success', 'Status updated successfully.');
    }

    public function toggleFeatured(Blog $blog)
    {
        $blog->update([
            'is_featured' => !$blog->is_featured
        ]);
        
        return back()->with('success', 'Featured status updated successfully.');
    }
}