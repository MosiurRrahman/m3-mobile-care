<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PaymentLog extends Model
{
    /**
     * The attributes that are fillable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'payable_type',
        'payable_id',
        'payment_method',
        'amount',
        'transaction_type',
    ];

    /**
     * Get the owning payable model (Sale or Repair).
     */
    public function payable(): MorphTo
    {
        return $this->morphTo();
    }
}
