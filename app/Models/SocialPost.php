<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsActivity;

class SocialPost extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'platform',
        'content',
        'media_path',
        'scheduled_at',
        'status',
        'reach',
        'engagement',
        'published_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
    ];
}
