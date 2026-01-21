<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'sent_by',
        'type',
        'subject',
        'message',
        'metadata',
        'sent_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'sent_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function getSentDateAttribute()
    {
        return $this->sent_at->format('M d, Y h:i A');
    }

    public function getTypeBadgeAttribute()
    {
        $badges = [
            'status_update' => 'bg-blue-100 text-blue-800',
            'custom_message' => 'bg-green-100 text-green-800',
            'interview_schedule' => 'bg-yellow-100 text-yellow-800',
            'offer_letter' => 'bg-purple-100 text-purple-800',
            'other' => 'bg-gray-100 text-gray-800',
        ];

        return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . 
               ($badges[$this->type] ?? $badges['other']) . '">' .
               ucfirst(str_replace('_', ' ', $this->type)) .
               '</span>';
    }
}