<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CompanyController as AdminCompanyController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ----------------- Public routes -----------------
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// ----------------- Auth routes -----------------
require __DIR__.'/auth.php';

// ----------------- Authenticated routes -----------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ----- Job Seeker routes -----
    Route::middleware(['role:job_seeker'])->prefix('job-seeker')->name('job-seeker.')->group(function () {
        Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');

        // Profile Routes
        Route::prefix('professional-profile')->name('professional-profile.')->group(function () {
            Route::get('/', [JobSeekerProfileController::class, 'edit'])->name('edit');
            Route::post('/basic-update', [JobSeekerProfileController::class, 'updateBasicProfile'])->name('basic-update');
            Route::post('/personal-info/update', [JobSeekerProfileController::class, 'updatePersonalInfo'])->name('personal-info.update');

            // Education routes
            Route::post('/education', [JobSeekerProfileController::class, 'storeEducation'])->name('education.store');
            Route::put('/education/{education}', [JobSeekerProfileController::class, 'updateEducation'])->name('education.update');
            Route::delete('/education/{education}', [JobSeekerProfileController::class, 'destroyEducation'])->name('education.destroy');

            // Skill routes
            Route::post('/skill', [JobSeekerProfileController::class, 'storeSkill'])->name('skill.store');
            Route::put('/skill/{skill}', [JobSeekerProfileController::class, 'updateSkill'])->name('skill.update');
            Route::delete('/skill/{skill}', [JobSeekerProfileController::class, 'destroySkill'])->name('skill.destroy');

            // Experience routes
            Route::post('/experience', [JobSeekerProfileController::class, 'storeExperience'])->name('experience.store');
            Route::put('/experience/{experience}', [JobSeekerProfileController::class, 'updateExperience'])->name('experience.update');
            Route::delete('/experience/{experience}', [JobSeekerProfileController::class, 'destroyExperience'])->name('experience.destroy');

            // Project routes
            Route::post('/project', [JobSeekerProfileController::class, 'storeProject'])->name('project.store');
            Route::put('/project/{project}', [JobSeekerProfileController::class, 'updateProject'])->name('project.update');
            Route::delete('/project/{project}', [JobSeekerProfileController::class, 'destroyProject'])->name('project.destroy');

            // Certification routes
            Route::post('/certification', [JobSeekerProfileController::class, 'storeCertification'])->name('certification.store');
            Route::put('/certification/{certification}', [JobSeekerProfileController::class, 'updateCertification'])->name('certification.update');
            Route::delete('/certification/{certification}', [JobSeekerProfileController::class, 'destroyCertification'])->name('certification.destroy');

            // Social Link routes
            Route::post('/social-link', [JobSeekerProfileController::class, 'storeSocialLink'])->name('social-link.store');
            Route::put('/social-link/{socialLink}', [JobSeekerProfileController::class, 'updateSocialLink'])->name('social-link.update');
            Route::delete('/social-link/{socialLink}', [JobSeekerProfileController::class, 'destroySocialLink'])->name('social-link.destroy');

            // Visibility settings
            Route::post('/visibility', [JobSeekerProfileController::class, 'updateVisibilitySettings'])->name('visibility.update');

            // Profile stats
            Route::get('/stats', [JobSeekerProfileController::class, 'getProfileStats'])->name('stats');

            // Profile photo routes 
            Route::post('/photo', [JobSeekerProfileController::class, 'updateProfilePhoto'])->name('photo.update');
            Route::delete('/photo', [JobSeekerProfileController::class, 'deleteProfilePhoto'])->name('photo.delete');
            Route::post('/complete-update', [JobSeekerProfileController::class, 'completeUpdate'])->name('complete-update');

            // Job Seeker Profile Routes 
            Route::post('/resume', [JobSeekerProfileController::class, 'uploadResume'])->name('resume.upload');
            Route::delete('/resume', [JobSeekerProfileController::class, 'deleteResume'])->name('resume.delete');
        });
        
        // Applications
        Route::get('/applications', [ApplicationController::class, 'myApplications'])->name('applications');
    });

    // Application routes (for all authenticated users)
    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'apply'])->name('jobs.apply');

    // ----- Admin routes -----
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Jobs
        Route::resource('jobs', AdminJobController::class);
        Route::post('/jobs/{job}/status', [AdminJobController::class, 'updateStatus'])->name('jobs.update-status');

        // Applications
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
        Route::post('/applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.update-status');
        Route::delete('/applications/{application}', [AdminApplicationController::class, 'destroy'])->name('applications.destroy');

        // Users
        Route::resource('users', AdminUserController::class);
        Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Categories
        Route::resource('categories', CategoryController::class);
        Route::patch('categories/{category}/status', [CategoryController::class, 'updateStatus'])->name('categories.update-status');

        // Companies
        Route::resource('companies', AdminCompanyController::class);

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::delete('/settings/logo', [SettingController::class, 'deleteLogo'])->name('settings.deleteLogo');

        Route::get('/contact-messages', [PageController::class, 'contactMessages'])->name('contact.messages');
        Route::get('/contact-messages/{id}', [PageController::class, 'showContactMessage'])->name('contact.show');
        Route::post('/contact-messages/{id}/reply', [PageController::class, 'replyContactMessage'])->name('contact.reply');
        Route::put('/contact-messages/{id}', [PageController::class, 'updateContactMessage'])->name('contact.update');
        Route::delete('/contact-messages/{id}', [PageController::class, 'deleteContactMessage'])->name('contact.delete');
    });
});