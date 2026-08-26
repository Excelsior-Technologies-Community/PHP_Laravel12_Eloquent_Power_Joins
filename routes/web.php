<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PowerJoinController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('orders', OrderController::class);
Route::resource('users', UserController::class);
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);

Route::prefix('power-joins')->name('power-joins.')->group(function () {
    Route::get('/nested', [PowerJoinController::class, 'nestedJoins'])->name('nested');
    Route::get('/left-join', [PowerJoinController::class, 'leftJoins'])->name('left-join');
    Route::get('/aggregate', [PowerJoinController::class, 'aggregateQueries'])->name('aggregate');
    Route::get('/group-by', [PowerJoinController::class, 'groupByExamples'])->name('group-by');
});
