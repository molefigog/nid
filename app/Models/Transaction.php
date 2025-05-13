<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'items',
        'invoice_number',
        'total',
        'change',
        'cash_paid',
        'payment_methods'

    ];
    protected $casts = [
        'items' => 'array',
        'payment_methods' => 'array',
    ];

    public function refunds()
    {
        return $this->hasMany(Refunds::class);
    }
    // public function items()
    // {
    //     return $this->hasMany(Product::class); // or whatever your item model is
    // }
}
