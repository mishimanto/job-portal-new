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
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }
        
        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }
        
        if ($request->filled('salary_min')) {
            $query->where('salary', '>=', $request->salary_min);
        }
        
        if ($request->filled('salary_max')) {
            $query->where('salary', '<=', $request->salary_max);
        }
        
        $jobs = $query->orderBy('created_at', 'desc')->paginate(15);
        
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