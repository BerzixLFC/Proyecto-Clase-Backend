<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::controller(ProductController::class)->prefix('product')->group(function () {
    Route::get('/', 'index')->name('product.index'); 
    Route::get('/create', 'create')->name('product.create');
    Route::post('/store', 'store')->name('product.store'); 
    Route::get('/{id}/{categoria?}', 'show')->name('product.show');
    Route::delete('/{product}', 'destroy')->name('product.destroy');
});