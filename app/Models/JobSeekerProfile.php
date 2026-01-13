<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeekerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'skills',
        'experience_level',
        'education',
        'resume_file',
        'work_experience',
        'education_history'
    ];

    protected $casts = [
        'skills' => 'array',
        'work_experience' => 'array',
        'education_history' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformation::class, 'personal_info_id');
    }

    // Get resume URL
    public function getResumeUrlAttribute()
    {
        return $this->resume_file ? asset('storage/' . $this->resume_file) : null;
    }

    // Check if resume is downloadable
    public function getIsResumeDownloadableAttribute()
    {
        return $this->resume_file && $this->make_resume_public;
    }
}