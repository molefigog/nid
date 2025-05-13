<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qoute extends Model
{
    protected $fillable = [
        'qoutation_number',
        'total',
        'items',
        'customer',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
