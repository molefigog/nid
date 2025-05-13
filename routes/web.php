<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\MpesaCharge;

Route::get('/mpesa', MpesaCharge::class,);
Route::get('welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('vcl');
});
