<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

// ================= RUTAS DE PRODUCTOS Y ADMIN =================
Route::controller(ProductController::class)->prefix('product')->group(function () {
    Route::get('/admin', 'adminIndex')->name('product.admin');
    Route::get('/', 'index')->name('product.index'); 
    Route::get('/create', 'create')->name('product.create');
    Route::post('/store', 'store')->name('product.store'); 
    Route::get('/{id}/{categoria?}', 'show')->name('product.show');
    Route::put('/{product}', 'update')->name('product.update'); 
    Route::delete('/{product}', 'destroy')->name('product.destroy');

    Route::post('/categories', 'storeCategory')->name('category.store');
    Route::put('/categories/{id}', 'updateCategory')->name('category.update');
    Route::delete('/categories/{id}', 'destroyCategory')->name('category.destroy');

    Route::post('/settings', 'updateHomeSettings')->name('admin.settings.update');
});

// ================= RUTAS DEL CARRITO DE COMPRAS =================
Route::controller(CartController::class)->prefix('cart')->group(function () {
    Route::get('/', 'index')->name('cart.index');
    Route::post('/add/{productId}', 'add')->name('cart.add');
    Route::delete('/remove/{id}', 'remove')->name('cart.remove');
    Route::post('/clear', 'clear')->name('cart.clear');
    
    // NUEVA RUTA: Pantalla de éxito
    Route::get('/success', 'success')->name('cart.success');
});