<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\Category;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        $query = Job::active();
        
        // Search filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('company_name', 'like', '%' . $search . '%');
                //   ->orWhere('requirements', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        // Array filters for job_type
        if ($request->has('job_type') && is_array($request->job_type) && count($request->job_type) > 0) {
            $query->whereIn('job_type', $request->job_type);
        }
        
        // Array filters for experience_level
        if ($request->has('experience_level') && is_array($request->experience_level) && count($request->experience_level) > 0) {
            $query->whereIn('experience_level', $request->experience_level);
        }
        
        // Salary filters
        if ($request->filled('salary_min')) {
            $query->where(function($q) use ($request) {
                $q->where('salary_min', '>=', $request->salary_min)
                  ->orWhere('salary_max', '>=', $request->salary_min)
                  ->orWhere('salary', '>=', $request->salary_min);
            });
        }
        
        if ($request->filled('salary_max')) {
            $query->where(function($q) use ($request) {
                $q->where('salary_max', '<=', $request->salary_max)
                  ->orWhere('salary_min', '<=', $request->salary_max)
                  ->orWhere('salary', '<=', $request->salary_max);
            });
        }
        
        // Category filter
        if ($request->has('categories') && is_array($request->categories) && count($request->categories) > 0) {
            $query->whereIn('category_id', $request->categories);
        }
        
        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'salary_high':
                $query->orderByRaw('COALESCE(salary_max, salary_min, salary) DESC NULLS LAST');
                break;
            case 'salary_low':
                $query->orderByRaw('COALESCE(salary_min, salary_max, salary) ASC NULLS LAST');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $jobs = $query->paginate(12)->withQueryString();
        
        return view('jobs.index', compact('jobs', 'categories'));
    }

    public function show(Job $job, Request $request)
    {
        // Track view by IP address
        $job->incrementView($request->ip());
        
        $job->load('user');
        
        // Check if user has applied
        $hasApplied = false;
        if (auth()->check() && auth()->user()->isJobSeeker()) {
            $hasApplied = $job->applications()
                ->where('user_id', auth()->id())
                ->exists();
        }
        
        return view('jobs.show', compact('job', 'hasApplied'));
    }
}