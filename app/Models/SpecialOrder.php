<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class SpecialOrder extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'order_number',
        'customer_id',
        'customer_name',
        'customer_phone',
        'item_name',
        'brand',
        'device_model',
        'source_supplier',
        'estimated_cost',
        'courier_cost',
        'selling_price',
        'advance_paid',
        'due_amount',
        'advance_payment_method',
        'final_payment_method',
        'status', // pending, ordered_from_dhaka, received_in_shop, delivered, cancelled
        'expected_delivery_date',
        'notes',
        'branch',
        'created_by',
        'received_at',
        'delivered_at',
    ];

    protected function casts(): array
    {
        return [
            'expected_delivery_date' => 'date',
            'received_at' => 'datetime',
            'delivered_at' => 'datetime',
            'estimated_cost' => 'decimal:2',
            'courier_cost' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'advance_paid' => 'decimal:2',
            'due_amount' => 'decimal:2',
        ];
    }

    /**
     * Get the customer relation.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the staff user who created this order.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Calculate estimated profit: Selling Price - (Estimated Cost + Courier Cost)
     */
    public function getEstimatedProfitAttribute(): float
    {
        return floatval($this->selling_price) - (floatval($this->estimated_cost) + floatval($this->courier_cost));
    }
}
