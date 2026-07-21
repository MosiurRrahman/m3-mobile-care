<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerBalance extends Model
{
    protected $fillable = [
        'partner_name',
        'capital_balance',
        'accumulated_profit',
        'payback_completed_at',
    ];

    protected $casts = [
        'payback_completed_at' => 'datetime',
    ];
}
