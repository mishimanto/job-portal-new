<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'profile_photo',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isJobSeeker()
    {
        return $this->role === 'job_seeker';
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
    public function personalInformation(): HasOne
    {
        return $this->hasOne(PersonalInformation::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class);
    }

    public function profileVisibilitySetting(): HasOne
    {
        return $this->hasOne(ProfileVisibilitySetting::class);
    }

    public function profileViews(): HasMany
    {
        return $this->hasMany(ProfileView::class);
    }

    public function jobSeekerProfile(): HasOne
    {
        return $this->hasOne(JobSeekerProfile::class);
    }
     // Relationships
    public function personalInfo()
    {
        return $this->hasOne(PersonalInformation::class, 'user_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'user_id');
    }

    public function profileVisibilitySettings()
    {
        return $this->hasOne(ProfileVisibilitySetting::class, 'user_id');
    }


    public function postedJobs()
    {
        return $this->hasMany(Job::class, 'user_id');
    }
}