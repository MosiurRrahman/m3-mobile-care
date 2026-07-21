<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\LogsActivity;

class Expense extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'category', // Rent, Salary, Utility, Purchase, Other
        'amount',
        'description',
        'expense_date',
        'register_type',
    ];
}
