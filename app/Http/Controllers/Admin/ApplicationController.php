<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\Job;
use App\Notifications\ApplicationStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // Load application with related data
        $application->load([
            'user', 
            'job',
            'user.personalInformation',
            'user.educations',
            'user.experiences',
            'user.skills',
            'user.projects',
            'user.certifications',
            'user.socialLinks',
            'user.jobSeekerProfile'
        ]);
        
        // Get interview time and joining date from notes
        $interviewTime = $application->interview_time;
        $joiningDate = $application->joining_date;
        
        return view('admin.applications.show', compact('application', 'interviewTime', 'joiningDate'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,reviewed,shortlisted,rejected,hired',
            'interview_time' => 'required_if:status,shortlisted|nullable|date',
            'joining_date' => 'required_if:status,hired|nullable|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $status = $request->status;
        $interviewTime = $request->interview_time;
        $joiningDate = $request->joining_date;
        
        // Validate required fields based on status
        if ($status === 'shortlisted' && !$interviewTime) {
            return redirect()->back()
                ->with('error', 'Interview time is required for shortlisted status.')
                ->withInput();
        }
        
        if ($status === 'hired' && !$joiningDate) {
            return redirect()->back()
                ->with('error', 'Joining date is required for hired status.')
                ->withInput();
        }
        
        // Update application
        $application->status = $status;
        
        if ($status === 'reviewed' && !$application->reviewed_at) {
            $application->reviewed_at = now();
        }
        
        if ($request->notes) {
            $application->notes = $request->notes;
        }
        
        // Store interview time or joining date in interview_notes
        if ($interviewTime) {
            $application->setInterviewTime($interviewTime);
        }
        
        if ($joiningDate) {
            $application->setJoiningDate($joiningDate);
        }
        
        $application->save();
        
        // Send email notification for specific statuses
        if (in_array($status, ['shortlisted', 'hired'])) {
            try {
                $application->user->notify(
                    new ApplicationStatusUpdated($application, $interviewTime, $joiningDate)
                );
                
                // Log email sent
                $application->interview_notes = array_merge(
                    $application->interview_notes ?? [],
                    ['email_sent_at' => now()->toDateTimeString()]
                );
                $application->save();
                
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('admin.applications.show', $application)
            ->with('success', 'Application status updated successfully.');
    }

    public function destroy(JobApplication $application)
    {
        $application->delete();
        
        return redirect()->route('admin.applications.index')
            ->with('success', 'Application deleted successfully.');
    }

    public function resumePreview(JobApplication $application)
    {
    
        // if (!auth()->user()->is_admin) {
        //     abort(403);
        // }
        
        if (!$application->resume) {
            abort(404, 'Resume not found');
        }
        
        $filename = $application->resume;
        
        if (!str_starts_with($filename, 'resumes/')) {
            $filename = 'resumes/' . $filename;
        }
        
        $path = public_path('storage/' . $filename);
        
        if (!file_exists($path)) {
            \Log::error('Resume file not found at: ' . $path);
            abort(404, 'Resume file not found at: ' . $path);
        }
        
        \Log::info('Resume found at: ' . $path);
        
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="resume_' . $application->user->name . '.pdf"',
            'X-Frame-Options' => 'SAMEORIGIN',
        ]);
    }
}