<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerLedgerEntry extends Model
{
    protected $fillable = [
        'partner_name',
        'account_type',
        'type',
        'amount',
        'balance_after',
        'month',
        'description',
        'created_by',
    ];

    /**
     * Get the user who registered this entry.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
