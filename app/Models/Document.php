<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsActivity;

class Document extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'document_number',
        'type',
        'title',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'date',
        'content',
        'notes',
        'status',
        'font_family',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            'mou' => 'MoU (সমঝোতা স্মারক)',
            'agreement' => 'Agreement (চুক্তিপত্র)',
            'voucher' => 'Voucher (ভাউচার)',
            'notice' => 'Notice (নোটিশ)',
            default => 'Custom Document (অন্যান্য)',
        };
    }

    public function getTypeBadgeClassAttribute()
    {
        return match ($this->type) {
            'mou' => 'bg-label-primary',
            'agreement' => 'bg-label-info',
            'voucher' => 'bg-label-success',
            'notice' => 'bg-label-warning',
            default => 'bg-label-secondary',
        };
    }
}
