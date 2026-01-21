<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'user_id',
        'cover_letter',
        'resume',
        'status',
        'interview_notes',
        'applied_at', // ✅ Added this
        'reviewed_at', // ✅ Added this
        'notes', // ✅ Added this
    ];

    protected $casts = [
        'interview_notes' => 'array',
        'applied_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    // ✅ Status constants for easy reference
    const STATUS_PENDING = 'pending';
    const STATUS_REVIEWED = 'reviewed';
    const STATUS_SHORTLISTED = 'shortlisted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_HIRED = 'hired';

    // ✅ Status options for forms
    public static function statusOptions()
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_REVIEWED => 'Reviewed',
            self::STATUS_SHORTLISTED => 'Shortlisted',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_HIRED => 'Hired',
        ];
    }

    // ✅ Boot method to set applied_at automatically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            if (empty($application->applied_at)) {
                $application->applied_at = now();
            }
        });
    }

    // ✅ Relationships
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ Status check methods
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isReviewed()
    {
        return $this->status === self::STATUS_REVIEWED;
    }

    public function isShortlisted()
    {
        return $this->status === self::STATUS_SHORTLISTED;
    }

    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isHired()
    {
        return $this->status === self::STATUS_HIRED;
    }

    // ✅ Get status badge color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_REVIEWED => 'blue',
            self::STATUS_SHORTLISTED => 'green',
            self::STATUS_REJECTED => 'red',
            self::STATUS_HIRED => 'purple',
            default => 'gray',
        };
    }

    // ✅ Get status badge class for Tailwind
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_REVIEWED => 'bg-blue-100 text-blue-800',
            self::STATUS_SHORTLISTED => 'bg-green-100 text-green-800',
            self::STATUS_REJECTED => 'bg-red-100 text-red-800',
            self::STATUS_HIRED => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // ✅ Get resume URL
    public function getResumeUrlAttribute()
    {
        if (!$this->resume) {
            return null;
        }
        
        // Check if it's a full URL or a storage path
        if (filter_var($this->resume, FILTER_VALIDATE_URL)) {
            return $this->resume;
        }
        
        return asset('storage/' . $this->resume);
    }

    // ✅ Get resume file name
    public function getResumeFileNameAttribute()
    {
        if (!$this->resume) {
            return null;
        }
        
        return basename($this->resume);
    }

    // ✅ Check if application has resume
    public function hasResume()
    {
        return !empty($this->resume);
    }

    // ✅ Scopes for filtering
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', self::STATUS_REVIEWED);
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', self::STATUS_SHORTLISTED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeHired($query)
    {
        return $query->where('status', self::STATUS_HIRED);
    }

    // ✅ Scope for recent applications
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('applied_at', '>=', now()->subDays($days));
    }

    // ✅ Update status with timestamp
    public function updateStatus($status, $notes = null)
    {
        $this->status = $status;
        
        if ($status === self::STATUS_REVIEWED && !$this->reviewed_at) {
            $this->reviewed_at = now();
        }
        
        if ($notes) {
            $this->notes = $notes;
        }
        
        return $this->save();
    }

    // ✅ Get interview time from interview_notes
    public function getInterviewTimeAttribute()
    {
        $notes = $this->interview_notes ?? [];
        return $notes['interview_time'] ?? null;
    }

    // ✅ Get joining date from interview_notes
    public function getJoiningDateAttribute()
    {
        $notes = $this->interview_notes ?? [];
        return $notes['joining_date'] ?? null;
    }

    // ✅ Set interview time
    public function setInterviewTime($time)
    {
        $notes = $this->interview_notes ?? [];
        $notes['interview_time'] = $time;
        $this->interview_notes = $notes;
    }

    // ✅ Set joining date
    public function setJoiningDate($date)
    {
        $notes = $this->interview_notes ?? [];
        $notes['joining_date'] = $date;
        $this->interview_notes = $notes;
    }

    // ✅ Check if email should be sent for current status
    public function shouldSendEmail()
    {
        return in_array($this->status, [
            self::STATUS_SHORTLISTED,
            self::STATUS_HIRED
        ]);
    }

    public function emails()
    {
        return $this->hasMany(ApplicationEmail::class);
    }
}