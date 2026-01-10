<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    // ✅ Specify the custom table name
    protected $table = 'open_jobs';

    protected $fillable = [
        'title',
        'user_id',
        'description',
        'company_name',
        'company_logo',
        'location',
        'salary',
        'salary_min',
        'salary_max',
        'salary_type',
        'salary_currency',
        'job_type',
        'experience_level',
        'skills_required',
        'benefits',
        'application_deadline',
        'is_active',
        'status',
        'views',
        'category_id',
        'company_id',
        'is_negotiable', // ✅ এই লাইন যোগ করুন
    ];

    protected $casts = [
        'skills_required' => 'array',
        'benefits' => 'array',
        'application_deadline' => 'date',
        'is_active' => 'boolean',
        'is_negotiable' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        // 'salary' => 'decimal:2', // ❌ এই লাইন রিমুভ করুন বা কমেন্ট করুন
    ];

    // ✅ Custom accessor for salary field
    public function getSalaryAttribute($value)
    {
        // If value is "Negotiable" or other string, return as is
        if (!is_numeric($value)) {
            return $value;
        }
        
        // If it's numeric, format with 2 decimal places
        return number_format((float)$value, 2, '.', '');
    }

    // ✅ Custom mutator for salary field
    public function setSalaryAttribute($value)
    {
        // If value is "Negotiable" or empty string, store as is
        if ($value === 'Negotiable' || $value === '' || $value === null) {
            $this->attributes['salary'] = $value;
        } 
        // If it's numeric, store as numeric
        elseif (is_numeric($value)) {
            $this->attributes['salary'] = (float)$value;
        }
        // Otherwise store as string
        else {
            $this->attributes['salary'] = $value;
        }
    }

    // ✅ Custom accessor for salary_min to handle null
    public function getSalaryMinAttribute($value)
    {
        return $value !== null ? (float)$value : null;
    }

    // ✅ Custom accessor for salary_max to handle null
    public function getSalaryMaxAttribute($value)
    {
        return $value !== null ? (float)$value : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    public function views()
    {
        return $this->hasMany(JobView::class, 'job_id');
    }

    public function incrementView($ipAddress)
    {
        if (!$this->views()->where('ip_address', $ipAddress)->exists()) {
            $this->views()->create(['ip_address' => $ipAddress]);
            $this->increment('views');
        }
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}