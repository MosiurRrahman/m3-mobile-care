<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Traits\LogsActivity;

class Repair extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'ticket_id',
        'customer_id',
        'device_brand',
        'device_model',
        'serial_imei',
        'issue_description',
        'password_pattern',
        'status', // pending, diagnosing, waiting_for_approval, repairing, quality_check, completed, delivered, cancelled
        'estimated_cost',
        'advance_payment',
        'actual_cost',
        'technician_notes',
        'assigned_technician_id',
        'expected_delivery_date',
        'branch',
        'device_checklist',
        'device_photos',
        'commission_type',
        'commission_rate',
        'commission_amount',
        'used_parts',
        'is_stock_deducted',
        'pattern_lock_path',
        'data_loss_consent',
        'warranty_days',
        'warranty_expiry_date',
        'repair_charge',
        'advance_payment_method',
        'payment_method',
        'cash_received',
        'change_returned',
        'completed_at',
        'paid_amount',
        'due_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'device_checklist' => 'array',
            'device_photos' => 'array',
            'used_parts' => 'array',
        ];
    }

    /**
     * Get the customer of this repair ticket.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the technician assigned to this repair.
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_technician_id');
    }

    /**
     * Get all payment logs associated with this repair.
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(PaymentLog::class, 'payable');
    }
}
