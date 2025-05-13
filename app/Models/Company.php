<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'address',
        'vat_number',
        'contact',
        'logo',
        'email',
        'acc',
        'branch_code',
        'bank'
    ];
}
