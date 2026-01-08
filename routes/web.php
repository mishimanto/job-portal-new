<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\JobSeeker\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\JobSeekerProfileController; 

// Public routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Job Seeker routes
    Route::middleware(['role:job_seeker'])->prefix('job-seeker')->name('job-seeker.')->group(function () {
        Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');
        
        // Profile Routes - Use only JobSeekerProfileController
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [JobSeekerProfileController::class, 'edit'])->name('edit');
            Route::post('/personal-info', [JobSeekerProfileController::class, 'updatePersonalInfo'])->name('personal-info.update');
            Route::post('/education', [JobSeekerProfileController::class, 'storeEducation'])->name('education.store');
            Route::put('/education/{education}', [JobSeekerProfileController::class, 'updateEducation'])->name('education.update');
            Route::delete('/education/{education}', [JobSeekerProfileController::class, 'destroyEducation'])->name('education.destroy');
            Route::post('/skill', [JobSeekerProfileController::class, 'storeSkill'])->name('skill.store');
            Route::put('/skill/{skill}', [JobSeekerProfileController::class, 'updateSkill'])->name('skill.update');
            Route::delete('/skill/{skill}', [JobSeekerProfileController::class, 'destroySkill'])->name('skill.destroy');
            Route::post('/experience', [JobSeekerProfileController::class, 'storeExperience'])->name('experience.store');
            Route::put('/experience/{experience}', [JobSeekerProfileController::class, 'updateExperience'])->name('experience.update');
            Route::delete('/experience/{experience}', [JobSeekerProfileController::class, 'destroyExperience'])->name('experience.destroy');
            Route::post('/project', [JobSeekerProfileController::class, 'storeProject'])->name('project.store');
            Route::put('/project/{project}', [JobSeekerProfileController::class, 'updateProject'])->name('project.update');
            Route::delete('/project/{project}', [JobSeekerProfileController::class, 'destroyProject'])->name('project.destroy');
            Route::post('/certification', [JobSeekerProfileController::class, 'storeCertification'])->name('certification.store');
            Route::put('/certification/{certification}', [JobSeekerProfileController::class, 'updateCertification'])->name('certification.update');
            Route::delete('/certification/{certification}', [JobSeekerProfileController::class, 'destroyCertification'])->name('certification.destroy');
            Route::post('/social-link', [JobSeekerProfileController::class, 'storeSocialLink'])->name('social-link.store');
            Route::put('/social-link/{socialLink}', [JobSeekerProfileController::class, 'updateSocialLink'])->name('social-link.update');
            Route::delete('/social-link/{socialLink}', [JobSeekerProfileController::class, 'destroySocialLink'])->name('social-link.destroy');
            Route::post('/visibility', [JobSeekerProfileController::class, 'updateVisibilitySettings'])->name('visibility.update');
            Route::get('/stats', [JobSeekerProfileController::class, 'getProfileStats'])->name('stats');
        });
        
        // Applications (keep the existing route)
        Route::get('/applications', [ApplicationController::class, 'myApplications'])->name('applications');
    });
    
    // Application routes (for all authenticated users)
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'apply'])->name('jobs.apply');
    
    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Jobs
        Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create', [AdminJobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [AdminJobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}', [AdminJobController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{job}/edit', [AdminJobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [AdminJobController::class, 'update'])->name('jobs.update');
        Route::post('/jobs/{job}/status', [AdminJobController::class, 'updateStatus'])->name('jobs.update-status');
        Route::delete('/jobs/{job}', [AdminJobController::class, 'destroy'])->name('jobs.destroy');

        
        // Applications
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
        Route::post('/applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.update-status');
        Route::delete('/applications/{application}', [AdminApplicationController::class, 'destroy'])->name('applications.destroy');
        
        // Users
        // Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        // Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        // Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // User Management
        Route::resource('users', AdminUserController::class);
        Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Categories
        Route::resource('categories', CategoryController::class);
        Route::patch('categories/{category}/status', [CategoryController::class, 'updateStatus'])
            ->name('categories.update-status');
        
        // Companies
        Route::get('/companies', [AdminCompanyController::class, 'index'])->name('companies.index');
        Route::get('/companies/create', [AdminCompanyController::class, 'create'])->name('companies.create');
        Route::post('/companies', [AdminCompanyController::class, 'store'])->name('companies.store');
        Route::get('/companies/{company}', [AdminCompanyController::class, 'show'])->name('companies.show');
        Route::get('/companies/{company}/edit', [AdminCompanyController::class, 'edit'])->name('companies.edit');
        Route::put('/companies/{company}', [AdminCompanyController::class, 'update'])->name('companies.update');
        Route::delete('/companies/{company}', [AdminCompanyController::class, 'destroy'])->name('companies.destroy');
        
        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});