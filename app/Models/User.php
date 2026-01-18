<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
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

     // Get first name from personal information
    public function getFirstNameAttribute()
    {
        return $this->personalInformation?->first_name ?? $this->name;
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

    // Helper method to get full name
    public function getFullNameAttribute()
    {
        if ($this->personalInformation && 
            ($this->personalInformation->first_name || $this->personalInformation->last_name)) {
            return trim($this->personalInformation->first_name . ' ' . $this->personalInformation->last_name);
        }
        
        return $this->name;
    }
    
    // Helper method to get complete address
    public function getCompleteAddressAttribute()
    {
        if (!$this->personalInformation) {
            return $this->address;
        }
        
        $parts = [];
        if ($this->personalInformation->address) $parts[] = $this->personalInformation->address;
        if ($this->personalInformation->city) $parts[] = $this->personalInformation->city;
        if ($this->personalInformation->state) $parts[] = $this->personalInformation->state;
        if ($this->personalInformation->country) $parts[] = $this->personalInformation->country;
        if ($this->personalInformation->zip_code) $parts[] = $this->personalInformation->zip_code;
        
        return implode(', ', $parts);
    }
}