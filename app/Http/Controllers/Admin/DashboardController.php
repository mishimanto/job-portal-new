<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Stats
        $stats = $this->getBasicStats();
        
        // Chart Data
        $chartData = $this->getChartData();
        
        // Recent Data
        $recentData = $this->getRecentData();

        return view('admin.dashboard', array_merge($stats, $chartData, $recentData));
    }

    private function getBasicStats()
    {
        return [
            'total_jobs' => Job::count(),
            'pending_jobs' => Job::where('status', 'pending')->count(),
            'total_applications' => JobApplication::count(),
            'total_hires' => JobApplication::where('status', 'hired')->count(),
            'total_users' => User::where('role', 'job_seeker')->count(),
            'total_companies' => Company::count(),
            'active_jobs' => Job::where('is_active', 1)->count(),
            'inactive_jobs' => Job::where('is_active', 0)->count(),
        ];
    }

    private function getChartData()
{
    // 1. Job Status Distribution (Pie Chart)
    // Ensure all possible statuses are included
    $allJobStatuses = ['approved', 'pending', 'rejected'];
    $jobStatusQuery = Job::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();
    
    // Initialize with zero for all statuses
    $jobStatusData = [];
    foreach ($allJobStatuses as $status) {
        $jobStatusData[$status] = $jobStatusQuery[$status] ?? 0;
    }

    $jobStatusColors = [
        'approved' => 'rgba(34, 197, 94, 0.8)',    // Green
        'pending' => 'rgba(251, 191, 36, 0.8)',    // Yellow
        'rejected' => 'rgba(239, 68, 68, 0.8)'     // Red
    ];

    $jobStatusLabels = [
        'approved' => 'Approved',
        'pending' => 'Pending',
        'rejected' => 'Rejected'
    ];

    // 2. Application Status Distribution (Bar Chart)
    // Ensure all possible application statuses are included
    $allAppStatuses = ['pending', 'reviewed', 'shortlisted', 'hired', 'rejected'];
    $appStatusQuery = JobApplication::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();
    
    $appStatusData = [];
    foreach ($allAppStatuses as $status) {
        $appStatusData[$status] = $appStatusQuery[$status] ?? 0;
    }

    $appStatusColors = [
        'pending' => 'rgba(251, 191, 36, 0.8)',     // Yellow
        'reviewed' => 'rgba(59, 130, 246, 0.8)',    // Blue
        'shortlisted' => 'rgba(139, 92, 246, 0.8)', // Purple
        'hired' => 'rgba(34, 197, 94, 0.8)',        // Green
        'rejected' => 'rgba(239, 68, 68, 0.8)'      // Red
    ];

    $appStatusLabels = [
        'pending' => 'Pending',
        'reviewed' => 'Reviewed',
        'shortlisted' => 'Shortlisted',
        'hired' => 'Hired',
        'rejected' => 'Rejected'
    ];

    // 3. Jobs by Category (Bar Chart)
    $categoryData = $this->getCategoryData();

    // 4. Monthly Statistics (Line Chart)
    $monthlyStats = $this->getMonthlyStats();

    // 5. Experience Level Distribution (Pie Chart)
    $experienceData = $this->getExperienceData();

    // 6. Job Type Distribution
    $jobTypeData = $this->getJobTypeData();

    return [
        'job_status_data' => [
            'data' => $jobStatusData,
            'colors' => $jobStatusColors,
            'labels' => $jobStatusLabels
        ],
        'app_status_data' => [
            'data' => $appStatusData,
            'colors' => $appStatusColors,
            'labels' => $appStatusLabels
        ],
        'category_data' => $categoryData,
        'monthly_stats' => $monthlyStats,
        'experience_data' => $experienceData,
        'job_type_data' => $jobTypeData
    ];
}

private function getCategoryData()
{
    $categoryData = Job::join('categories', 'open_jobs.category_id', '=', 'categories.id')
        ->select('categories.name', DB::raw('count(open_jobs.id) as count'))
        ->groupBy('categories.id', 'categories.name')
        ->orderBy('count', 'desc')
        ->limit(8)
        ->get()
        ->toArray();

    // If no categories, use job types
    if (empty($categoryData)) {
        $categoryData = Job::select('job_type', DB::raw('count(*) as count'))
            ->groupBy('job_type')
            ->orderBy('count', 'desc')
            ->limit(8)
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->job_type ?: 'Not Specified',
                    'count' => $item->count
                ];
            })
            ->toArray();
    }

    return $categoryData;
}

private function getExperienceData()
{
    $experienceQuery = Job::select('experience_level', DB::raw('count(*) as count'))
        ->whereNotNull('experience_level')
        ->groupBy('experience_level')
        ->pluck('count', 'experience_level')
        ->toArray();

    // Ensure all experience levels
    $allExperienceLevels = ['entry', 'junior', 'mid', 'senior', 'lead'];
    $experienceData = [];
    foreach ($allExperienceLevels as $level) {
        $experienceData[$level] = $experienceQuery[$level] ?? 0;
    }

    $experienceColors = [
        'entry' => 'rgba(59, 130, 246, 0.8)',    // Blue
        'junior' => 'rgba(139, 92, 246, 0.8)',   // Purple
        'mid' => 'rgba(34, 197, 94, 0.8)',       // Green
        'senior' => 'rgba(245, 158, 11, 0.8)',   // Orange
        'lead' => 'rgba(239, 68, 68, 0.8)'       // Red
    ];

    return [
        'data' => $experienceData,
        'colors' => $experienceColors
    ];
}

private function getJobTypeData()
{
    $jobTypeQuery = Job::select('job_type', DB::raw('count(*) as count'))
        ->groupBy('job_type')
        ->pluck('count', 'job_type')
        ->toArray();

    // Ensure all job types
    $allJobTypes = ['full-time', 'part-time', 'contract', 'remote', 'internship'];
    $jobTypeData = [];
    foreach ($allJobTypes as $type) {
        $jobTypeData[$type] = $jobTypeQuery[$type] ?? 0;
    }

    $jobTypeColors = [
        'full-time' => 'rgba(34, 197, 94, 0.8)',    // Green
        'part-time' => 'rgba(59, 130, 246, 0.8)',   // Blue
        'contract' => 'rgba(245, 158, 11, 0.8)',    // Orange
        'remote' => 'rgba(139, 92, 246, 0.8)',      // Purple
        'internship' => 'rgba(239, 68, 68, 0.8)'    // Red
    ];

    return [
        'data' => $jobTypeData,
        'colors' => $jobTypeColors
    ];
}

    private function getMonthlyStats()
    {
        $currentYear = Carbon::now()->year;
        $months = [];
        $jobData = [];
        $applicationData = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthStart = Carbon::createFromDate($currentYear, $i, 1)->startOfMonth();
            $monthEnd = Carbon::createFromDate($currentYear, $i, 1)->endOfMonth();

            // Jobs created in this month
            $jobsCount = Job::whereBetween('created_at', [$monthStart, $monthEnd])->count();

            // Applications created in this month
            $appsCount = JobApplication::whereBetween('created_at', [$monthStart, $monthEnd])->count();

            $months[] = $monthStart->format('M');
            $jobData[] = $jobsCount;
            $applicationData[] = $appsCount;
        }

        return [
            'months' => $months,
            'jobs' => $jobData,
            'applications' => $applicationData
        ];
    }

    private function getRecentData()
    {
        return [
            'recent_jobs' => Job::with(['user', 'category'])
                ->where('status', 'pending')
                ->latest()
                ->limit(5)
                ->get(),
                
            'recent_applications' => JobApplication::with(['user', 'job'])
                ->latest()
                ->limit(5)
                ->get(),

            'recent_companies' => Company::latest()
                ->limit(5)
                ->get(),

            'recent_users' => User::where('role', 'job_seeker')
                ->latest()
                ->limit(5)
                ->get()
        ];
    }
}