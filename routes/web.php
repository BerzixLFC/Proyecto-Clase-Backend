<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::controller(ProductController::class)->prefix('product')->group(function () {
    // NUEVA RUTA: Panel de administrador
    Route::get('/admin', 'adminIndex')->name('product.admin');
    
    Route::get('/', 'index')->name('product.index'); 
    Route::get('/create', 'create')->name('product.create');
    Route::post('/store', 'store')->name('product.store'); 
    Route::get('/{id}/{categoria?}', 'show')->name('product.show');
    
    // Rutas para el modal y eliminar productos
    Route::put('/{product}', 'update')->name('product.update'); 
    Route::delete('/{product}', 'destroy')->name('product.destroy');

    // NUEVAS RUTAS: CRUD Categorías
    Route::post('/categories', 'storeCategory')->name('category.store');
    Route::put('/categories/{id}', 'updateCategory')->name('category.update');
    Route::delete('/categories/{id}', 'destroyCategory')->name('category.destroy');

    // NUEVA RUTA: Actualizar Landing Page
    Route::post('/settings', 'updateHomeSettings')->name('admin.settings.update');
});