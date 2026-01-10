<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobSeekerProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->jobSeekerProfile ?? new JobSeekerProfile();
        
        return view('jobseeker.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'skills' => 'nullable|string',
            'experience_level' => 'nullable|string',
            'education' => 'nullable|string',
            'resume_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'work_experience' => 'nullable|array',
            'education_history' => 'nullable|array',
        ]);

        $data = $request->except('resume_file');
        
        if ($request->hasFile('resume_file')) {
            $path = $request->file('resume_file')->store('resumes', 'public');
            $data['resume_file'] = $path;
        }

        if ($request->has('skills')) {
            $data['skills'] = array_map('trim', explode(',', $request->skills));
        }

        if ($user->jobSeekerProfile) {
            $user->jobSeekerProfile->update($data);
        } else {
            $data['user_id'] = $user->id;
            JobSeekerProfile::create($data);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}