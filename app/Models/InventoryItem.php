<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class InventoryItem extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'sku',
        'barcode',
        'type', // spare_part, accessory
        'category', // e.g. Display, Battery (legacy string representation)
        'quantity',
        'alert_quantity',
        'purchase_price',
        'sale_price',
        'min_sale_price',
        'branch',
        // Advanced fields
        'supplier_id',
        'category_id',
        'sub_category',
        'brand',
        'model',
        'description',
        'product_type', // single, variable
        'discount_type', // flat, percentage
        'discount_value',
        'images', // json cast
        'warranties',
        'manufacturer',
        'expiry',
        'variants', // json cast
    ];

    protected $casts = [
        'images' => 'array',
        'variants' => 'array',
        'expiry' => 'date',
        'min_sale_price' => 'float',
        'sale_price' => 'float',
        'purchase_price' => 'float',
    ];

    /**
     * Get minimum allowed selling price (fallback to sale_price if min_sale_price is not set).
     */
    public function getEffectiveMinPriceAttribute(): float
    {
        if ($this->min_sale_price !== null && $this->min_sale_price > 0) {
            return (float) $this->min_sale_price;
        }
        return (float) ($this->sale_price ?? 0);
    }

    /**
     * Get the supplier for this inventory item.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the category for this inventory item.
     */
    public function categoryRelation(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
