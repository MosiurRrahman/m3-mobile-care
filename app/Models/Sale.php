<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'customer_id',
        'total_amount',
        'discount',
        'payable_amount',
        'paid_amount',
        'due_amount',
        'cash_received',
        'change_returned',
        'payment_method',
        'salesman_id',
        'branch',
    ];

    /**
     * Get the customer of this sale.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the salesman/user who made the sale.
     */
    public function salesman(): BelongsTo
    {
        return $this->belongsTo(User::class, 'salesman_id');
    }

    /**
     * Get details for this sale.
     */
    public function details(): HasMany
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Get all payment logs associated with this sale.
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(PaymentLog::class, 'payable');
    }
}
