<?php

use App\Http\Controllers\ecommerceController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// ECOMMERCE
Route::get('/', [ecommerceController::class, 'index'])->name('ecommerce.index');

// ADMINISTRADOR
