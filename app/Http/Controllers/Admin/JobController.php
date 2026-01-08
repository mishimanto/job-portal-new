<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['user'])
            ->withCount('applications');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $jobs = $query->latest()->paginate(20);
        
        $totalJobs = Job::count();
        $pendingJobs = Job::where('status', 'pending')->count();
        $activeJobs = Job::where('is_active', true)->count();
        
        return view('admin.jobs.index', compact('jobs', 'totalJobs', 'pendingJobs', 'activeJobs'));
    }

    public function show(Job $job)
    {
        $job->load(['user']);
        $job->loadCount('applications');
        return view('admin.jobs.show', compact('job'));
    }

    public function updateStatus(Request $request, Job $job)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);
        
        $job->update([
            'status' => $request->status,
            'is_active' => $request->status == 'approved',
        ]);
        
        return redirect()->route('admin.jobs.show', $job)
            ->with('success', 'Job status updated successfully.');
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        $companies = Company::where('is_active', true)->orderBy('name')->get();
        return view('admin.jobs.create', compact('categories', 'companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'job_type' => 'required|string|in:full-time,part-time,contract,remote,internship',
            'experience_level' => 'required|string|in:intern,junior,mid,senior,lead,executive',
            'skills_required' => 'nullable|string',
            'benefits' => 'nullable|string',
            'application_deadline' => 'nullable|date|after_or_equal:today',
            'company_logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'status' => 'required|string|in:pending,approved,rejected',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Format skills required
        if ($request->filled('skills_required')) {
            $skills = array_map('trim', explode(',', $request->skills_required));
            $validated['skills_required'] = $skills; // Just assign the array
        }

        // Format benefits
        if ($request->filled('benefits')) {
            $benefits = array_filter(array_map('trim', explode("\n", $request->benefits)));
            $validated['benefits'] = $benefits; // Just assign the array
        }

        // Handle file upload
        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $request->file('company_logo')->store('company-logos', 'public');
        }

        // Set default values
        $validated['user_id'] = auth()->id();
        $validated['views'] = 0;

        // Create the job
        Job::create($validated);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job posted successfully.');
    }

    public function edit(Job $job)
    {
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        return view('admin.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'job_type' => 'required|string|in:full-time,part-time,contract,remote,internship',
            'experience_level' => 'required|string|in:intern,junior,mid,senior,lead,executive',
            'skills_required' => 'nullable|string',
            'benefits' => 'nullable|string',
            'application_deadline' => 'nullable|date|after_or_equal:today',
            'company_logo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'status' => 'required|string|in:pending,approved,rejected',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Format skills required
        if ($request->filled('skills_required')) {
            $skills = array_map('trim', explode(',', $request->skills_required));
            $validated['skills_required'] = $skills; // Just assign the array
        }

        // Format benefits
        if ($request->filled('benefits')) {
            $benefits = array_filter(array_map('trim', explode("\n", $request->benefits)));
            $validated['benefits'] = $benefits; // Just assign the array
        }

        // Handle file upload - new logo
        if ($request->hasFile('company_logo')) {
            // Delete old logo if exists
            if ($job->company_logo) {
                Storage::disk('public')->delete($job->company_logo);
            }
            $validated['company_logo'] = $request->file('company_logo')->store('company-logos', 'public');
        }

        // Handle logo removal if requested
        if ($request->has('remove_logo') && $request->remove_logo == '1') {
            if ($job->company_logo) {
                Storage::disk('public')->delete($job->company_logo);
            }
            $validated['company_logo'] = null;
        }

        $job->update($validated);

        return redirect()->route('admin.jobs.show', $job)
            ->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->applications()->delete();
        $job->delete();
        
        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job deleted successfully.');
    }
}