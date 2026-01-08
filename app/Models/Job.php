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
        'job_type',
        'experience_level',
        'skills_required',
        'benefits',
        'application_deadline',
        'is_active',
        'status',
        'views',
        'category_id'
    ];

    protected $casts = [
        'skills_required' => 'array',
        'benefits' => 'array',
        'application_deadline' => 'date',
        'is_active' => 'boolean',
        'salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id'); // foreign key is job_id
    }

    public function views()
    {
        return $this->hasMany(JobView::class, 'job_id'); // foreign key is job_id
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
