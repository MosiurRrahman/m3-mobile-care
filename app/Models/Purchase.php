<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class Purchase extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'purchase_no',
        'supplier_id',
        'total_amount',
        'purchase_date',
        'branch',
    ];

    /**
     * Get the supplier of this purchase.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get details for this purchase.
     */
    public function details(): HasMany
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
