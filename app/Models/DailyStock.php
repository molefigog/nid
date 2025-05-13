<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyStock extends Model
{
    protected $fillable = ['product_id', 'date', 'opening_stock', 'closing_stock'];
}
