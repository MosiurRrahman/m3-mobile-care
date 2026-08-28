<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use Prunable;

    protected $fillable = [
        'user_id',
        'loggable_type',
        'loggable_id',
        'action',
        'changes',
        'description',
        'ip_address',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    /**
     * Determine prunable query for auto-cleanup (default: 90 days retention).
     */
    public function prunable()
    {
        return static::where('created_at', '<=', now()->subDays(90));
    }

    /**
     * Get the user who performed the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent loggable model (Repair, SocialPost, etc.).
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }
}
