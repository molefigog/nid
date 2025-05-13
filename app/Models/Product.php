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
        'closing_stock_updated_at',
        'sc'
    ];
    protected static function booted()
    {
        static::creating(function ($product) {
            $product->sc = self::generateShortcode($product->name);
        });
    }

    public static function generateShortcode($name)
    {
        preg_match('/([A-Za-z]+)\s?([A-Za-z]+)?\s?(\d+[\.\*]?\d*)(mm)?\s?([A-Za-z]+)?/', $name, $matches);

        // Log products that don't match
        if (empty($matches)) {
            \Log::error("Failed to generate shortcode for product: {$name}");
        }

        // Safe checks to avoid warnings when matches are missing
        $initials = isset($matches[1]) && strlen($matches[1]) > 0 ? strtoupper($matches[1][0]) : '';
        $secondWord = isset($matches[2]) && strlen($matches[2]) > 0 ? strtoupper($matches[2][0]) : '';
        $number = isset($matches[3]) ? $matches[3] : '';
        $suffix = isset($matches[5]) && strlen($matches[5]) > 0 ? strtoupper($matches[5]) : '';

        return "{$initials}{$secondWord}{$number}{$suffix}";
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function adjustments()
    {
        return $this->hasMany(ProductAdjustment::class);
    }
}
