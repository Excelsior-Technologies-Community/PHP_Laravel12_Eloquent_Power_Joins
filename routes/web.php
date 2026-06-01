<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', [OrderController::class, 'index']);

Route::delete('/orders/{id}', [OrderController::class, 'destroy'])
    ->name('orders.destroy');