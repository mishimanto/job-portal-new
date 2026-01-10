<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with(['user', 'job']);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('job_id')) {
            $query->where('job_id', $request->job_id);
        }
        
        if ($request->filled('date')) {
            $query->whereDate('applied_at', $request->date);
        }
        
        $applications = $query->latest()->paginate(20);
        $jobs = Job::where('status', 'approved')->get();
        
        return view('admin.applications.index', compact('applications', 'jobs'));
    }

    public function show(JobApplication $application)
    {
        $application->load(['user', 'job']);
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,rejected,hired',
        ]);
        
        $application->update([
            'status' => $request->status,
            'reviewed_at' => now(),
            'notes' => $request->notes ?? $application->notes,
        ]);
        
        return redirect()->route('admin.applications.show', $application)
            ->with('success', 'Application status updated successfully.');
    }

    public function destroy(JobApplication $application)
    {
        $application->delete();
        
        return redirect()->route('admin.applications.index')
            ->with('success', 'Application deleted successfully.');
    }
}