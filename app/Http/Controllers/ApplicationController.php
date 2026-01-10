<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function apply(Request $request, Job $job)
    {
        // Check if user is authenticated and is a job seeker
        if (!Auth::check() || !Auth::user()->isJobSeeker()) {
            return redirect()->route('login')->with('error', 'Please login as a job seeker to apply.');
        }

        // Check if user has already applied
        $existingApplication = JobApplication::where('job_id', $job->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this job.');
        }

        $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = [
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
        ];

        // Handle resume upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $data['resume'] = $path;
        } elseif (Auth::user()->jobSeekerProfile && Auth::user()->jobSeekerProfile->resume_file) {
            // Use existing resume from profile
            $data['resume'] = Auth::user()->jobSeekerProfile->resume_file;
        }

        JobApplication::create($data);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    public function myApplications()
    {
        $applications = JobApplication::with(['job', 'job.user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }
}