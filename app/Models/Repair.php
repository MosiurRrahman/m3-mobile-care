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
        'status_updated_at',
        'status_history',
        'estimated_cost',
        'advance_payment',
        'actual_cost',
        'technician_notes',
        'assigned_technician_id',
        'assigned_at',
        'expected_delivery_date',
        'expected_date_reminder_sent_at',
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
            'data_loss_consent' => 'boolean',
            'assigned_at' => 'datetime',
            'status_updated_at' => 'datetime',
            'status_history' => 'array',
            'completed_at' => 'datetime',
            'expected_delivery_date' => 'date',
            'expected_date_reminder_sent_at' => 'datetime',
        ];
    }

    /**
     * Human-readable labels for repair statuses.
     */
    public static function statusLabels(): array
    {
        return [
            'pending' => 'Pending Confirmation',
            'diagnosing' => 'Diagnosing',
            'waiting_for_approval' => 'Waiting Approval',
            'waiting_for_parts' => 'Waiting for Parts',
            'repairing' => 'Repairing',
            'quality_check' => 'Quality Check',
            'completed' => 'Completed (Ready)',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];
    }

    /**
     * Booted model hooks for automatic tracking of assignment and status changes.
     */
    protected static function booted()
    {
        static::creating(function ($repair) {
            $now = now();

            if ($repair->assigned_technician_id && !$repair->assigned_at) {
                $repair->assigned_at = $now;
            }
            if (!$repair->status_updated_at) {
                $repair->status_updated_at = $now;
            }

            $history = is_array($repair->status_history) ? $repair->status_history : [];
            $userName = auth()->check() ? auth()->user()->name : 'System';
            $userId = auth()->id();
            $status = $repair->status ?: 'pending';
            $statusLabel = self::statusLabels()[$status] ?? ucfirst(str_replace('_', ' ', $status));

            $techName = null;
            if ($repair->assigned_technician_id) {
                $tech = User::find($repair->assigned_technician_id);
                $techName = $tech ? $tech->name : 'Tech #' . $repair->assigned_technician_id;
            }

            $history[] = [
                'type' => 'created',
                'status' => $status,
                'status_label' => $statusLabel,
                'technician_id' => $repair->assigned_technician_id,
                'technician_name' => $techName,
                'user_id' => $userId,
                'user_name' => $userName,
                'note' => $repair->technician_notes ?: 'Job Card created',
                'created_at' => $now->toDateTimeString(),
            ];

            if ($repair->assigned_technician_id) {
                $history[] = [
                    'type' => 'assignment',
                    'status' => $status,
                    'status_label' => $statusLabel,
                    'technician_id' => $repair->assigned_technician_id,
                    'technician_name' => $techName,
                    'user_id' => $userId,
                    'user_name' => $userName,
                    'note' => "Assigned to {$techName}",
                    'created_at' => $now->toDateTimeString(),
                ];
            }

            $repair->status_history = $history;
        });

        static::updating(function ($repair) {
            $now = now();
            $userName = auth()->check() ? auth()->user()->name : 'System';
            $userId = auth()->id();
            $history = is_array($repair->status_history) ? $repair->status_history : [];

            $isDirtyTech = $repair->isDirty('assigned_technician_id');
            $isDirtyStatus = $repair->isDirty('status');
            $isDirtyExpectedDate = $repair->isDirty('expected_delivery_date');

            // Reset reminder if expected date or assigned technician changed
            if (($isDirtyExpectedDate || $isDirtyTech) && !$repair->isDirty('expected_date_reminder_sent_at')) {
                $repair->expected_date_reminder_sent_at = null;
            }

            if ($isDirtyTech) {
                if ($repair->assigned_technician_id) {
                    $repair->assigned_at = $now;
                    $tech = User::find($repair->assigned_technician_id);
                    $techName = $tech ? $tech->name : 'Tech #' . $repair->assigned_technician_id;
                    $history[] = [
                        'type' => 'assignment',
                        'status' => $repair->status,
                        'status_label' => self::statusLabels()[$repair->status] ?? ucfirst(str_replace('_', ' ', $repair->status)),
                        'technician_id' => $repair->assigned_technician_id,
                        'technician_name' => $techName,
                        'user_id' => $userId,
                        'user_name' => $userName,
                        'note' => "Assigned to {$techName}",
                        'created_at' => $now->toDateTimeString(),
                    ];
                } else {
                    $repair->assigned_at = null;
                    $history[] = [
                        'type' => 'unassignment',
                        'status' => $repair->status,
                        'status_label' => self::statusLabels()[$repair->status] ?? ucfirst(str_replace('_', ' ', $repair->status)),
                        'technician_id' => null,
                        'technician_name' => null,
                        'user_id' => $userId,
                        'user_name' => $userName,
                        'note' => 'Technician unassigned',
                        'created_at' => $now->toDateTimeString(),
                    ];
                }
            }

            if ($isDirtyStatus) {
                $repair->status_updated_at = $now;
                $techName = null;
                if ($repair->assigned_technician_id) {
                    $tech = User::find($repair->assigned_technician_id);
                    $techName = $tech ? $tech->name : null;
                }
                $history[] = [
                    'type' => 'status_change',
                    'from_status' => $repair->getOriginal('status'),
                    'status' => $repair->status,
                    'status_label' => self::statusLabels()[$repair->status] ?? ucfirst(str_replace('_', ' ', $repair->status)),
                    'technician_id' => $repair->assigned_technician_id,
                    'technician_name' => $techName,
                    'user_id' => $userId,
                    'user_name' => $userName,
                    'note' => $repair->technician_notes,
                    'created_at' => $now->toDateTimeString(),
                ];
            }

            if ($isDirtyTech || $isDirtyStatus) {
                $repair->status_history = $history;
            }
        });
    }

    /**
     * Get timestamp of when a specific status was first/last set.
     */
    public function getStatusDate(string $statusKey): ?\Carbon\Carbon
    {
        if (is_array($this->status_history)) {
            foreach ($this->status_history as $item) {
                if (isset($item['status']) && $item['status'] === $statusKey && !empty($item['created_at'])) {
                    return \Carbon\Carbon::parse($item['created_at']);
                }
            }
        }

        // Fallbacks for legacy records without status history JSON
        if ($statusKey === 'pending') {
            return $this->created_at;
        }

        if ($statusKey === $this->status) {
            return $this->status_updated_at ?? $this->updated_at ?? $this->created_at;
        }

        if (in_array($statusKey, ['completed', 'delivered']) && $this->completed_at) {
            return $this->completed_at;
        }

        return null;
    }

    /**
     * Get assignment date safely.
     */
    public function getAssignedDate(): ?\Carbon\Carbon
    {
        if ($this->assigned_at) {
            return $this->assigned_at;
        }

        if ($this->assigned_technician_id) {
            return $this->created_at;
        }

        return null;
    }

    /**
     * Get last status update date safely.
     */
    public function getStatusUpdatedDate(): \Carbon\Carbon
    {
        return $this->status_updated_at ?? $this->updated_at ?? $this->created_at;
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

    public function paymentLogs(): MorphMany
    {
        return $this->morphMany(PaymentLog::class, 'payable');
    }

    /**
     * Get total parts purchase cost.
     */
    public function getTotalPartsCostAttribute(): float
    {
        $total = 0;
        if (is_array($this->used_parts)) {
            foreach ($this->used_parts as $part) {
                $total += floatval($part['buying_price'] ?? 0) * intval($part['quantity'] ?? 1);
            }
        }
        return $total;
    }

    /**
     * Get total courier/transport cost for outsourced parts.
     */
    public function getTotalCourierCostAttribute(): float
    {
        $total = 0;
        if (is_array($this->used_parts)) {
            foreach ($this->used_parts as $part) {
                $total += floatval($part['courier_cost'] ?? 0);
            }
        }
        return $total;
    }

    /**
     * Check if this job card has Dhaka / externally sourced parts.
     */
    public function getHasDhakaPartsAttribute(): bool
    {
        if (is_array($this->used_parts)) {
            foreach ($this->used_parts as $part) {
                $source = $part['source'] ?? '';
                if ($source === 'dhaka_supplier' || $source === 'external' || $source === 'local_shop') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Calculate Net Profit: (Actual Cost or Estimated Cost) - (Total Parts Cost + Courier Cost + Commission Amount)
     */
    public function getNetProfitAttribute(): float
    {
        $revenue = $this->actual_cost !== null ? floatval($this->actual_cost) : floatval($this->estimated_cost);
        $expenses = $this->total_parts_cost + $this->total_courier_cost + floatval($this->commission_amount ?? 0);
        return max(0, $revenue - $expenses);
    }
}
