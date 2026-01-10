<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobView extends Model
{
    use HasFactory;

    protected $fillable = ['job_id', 'ip_address'];

    public $timestamps = false;

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}