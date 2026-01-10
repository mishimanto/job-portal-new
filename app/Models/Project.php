<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'role',
        'technologies_used',
        'start_date',
        'end_date',
        'is_ongoing',
        'project_url',
        'images',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_ongoing' => 'boolean',
        'technologies_used' => 'array',
        'images' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}