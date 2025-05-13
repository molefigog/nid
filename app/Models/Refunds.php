<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refunds extends Model
{
    protected $fillable = [
        'transaction_id',
        'invoice_number',
        'amount',
        'reason',
        'items_returned',


    ];
    protected $casts = [
        'items_returned' => 'array',
    ];
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
