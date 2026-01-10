<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $applications = JobApplication::with('job')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $stats = [
            'total_applications' => $applications->total(),
            'pending' => JobApplication::where('user_id', $user->id)->where('status', 'pending')->count(),
            'shortlisted' => JobApplication::where('user_id', $user->id)->where('status', 'shortlisted')->count(),
            'hired' => JobApplication::where('user_id', $user->id)->where('status', 'hired')->count(),
        ];

        return view('jobseeker.dashboard', compact('applications', 'stats'));
    }
}