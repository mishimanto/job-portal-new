<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileVisibilitySetting extends Model
{
    protected $fillable = [
        'user_id',
        'make_profile_public',
        'show_education',
        'show_experience',
        'show_projects',
        'show_certifications',
        'show_skills',
        'show_social_links',
        'show_contact_info',
    ];

    protected $casts = [
        'make_profile_public' => 'boolean',
        'show_education' => 'boolean',
        'show_experience' => 'boolean',
        'show_projects' => 'boolean',
        'show_certifications' => 'boolean',
        'show_skills' => 'boolean',
        'show_social_links' => 'boolean',
        'show_contact_info' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}