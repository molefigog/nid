<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class ProductAdjustment extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'type', 'quantity', 'reason', 'adjusted_at'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : null;
    }

    protected $appends = [
        'product_name',

    ];
}
