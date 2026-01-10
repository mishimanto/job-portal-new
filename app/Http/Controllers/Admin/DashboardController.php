<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\Company;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalJobs = Job::count();
        $pendingJobs = Job::where('status', 'pending')->count();
        $totalApplications = JobApplication::count();
        $totalHires = JobApplication::where('status', 'hired')->count();
        $totalUsers = User::where('role', 'job_seeker')->count();
        $totalCompanies = Company::count();
        
        $recentJobs = Job::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();
            
        $recentApplications = JobApplication::with(['user', 'job'])
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'total_jobs' => $totalJobs,
            'pending_jobs' => $pendingJobs,
            'total_applications' => $totalApplications,
            'total_hires' => $totalHires,
            'total_users' => $totalUsers,
            'total_companies' => $totalCompanies,
        ];

        return view('admin.dashboard', compact('stats', 'recentJobs', 'recentApplications'));
    }
}