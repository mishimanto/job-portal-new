<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'issuing_organization',
        'issue_date',
        'expiration_date',
        'credential_id',
        'credential_url',
        'skills',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiration_date' => 'date',
        'skills' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}