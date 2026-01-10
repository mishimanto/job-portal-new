<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $jobs = $category->jobs()->latest()->paginate(10);
        return view('admin.categories.show', compact('category', 'jobs'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'order' => 'nullable|integer'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Check if category has jobs
        if ($category->jobs()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category because it has associated jobs. Please reassign or delete the jobs first.');
        }

        // Check if category has companies
        // if ($category->companies()->count() > 0) {
        //     return redirect()->route('admin.categories.index')
        //         ->with('error', 'Cannot delete category because it has associated companies. Please reassign or delete the companies first.');
        // }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function updateStatus(Request $request, Category $category)
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        $category->update(['is_active' => $request->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }
}