<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'barcode',
        'cost',
        'price',
        'stock',
        'alerts',
        'category_id',
        'opening_stock',
        'closing_stock',
        'closing_stock_updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function adjustments()
    {
        return $this->hasMany(ProductAdjustment::class);
    }
}
