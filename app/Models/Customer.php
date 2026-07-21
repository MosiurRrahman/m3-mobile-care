<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'alt_phone',
        'email',
        'address',
        'district',
    ];

    /**
     * Get all repairs for this customer.
     */
    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    /**
     * Get all sales POS bills for this customer.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
