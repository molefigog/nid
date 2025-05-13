<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoldItemsCollection extends Model
{
    protected $fillable = [
        'items',
        'invoice_number',
        'total',
        'change',
        'cash_paid',
        'payment_methods',
        'customer',
        'original_receipt_date'

    ];
    protected $casts = [
        'items' => 'array',
        'payment_methods' => 'array',
    ];
}
