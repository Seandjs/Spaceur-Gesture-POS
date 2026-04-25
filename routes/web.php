<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Cashier\PosController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::view('/gesture-login', 'cashier.gesture-login')->name('gesture-login');

    Route::get('/pos', [PosController::class, 'index'])->name('pos');
    Route::post('/pos/add', [PosController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/pos/remove', [PosController::class, 'removeFromCart'])->name('remove-from-cart');
    Route::post('/pos/clear', [PosController::class, 'clearCart'])->name('clear-cart');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('checkout');

    Route::get('/sales', [PosController::class, 'salesHistory'])->name('sales-history');
    Route::get('/sales/{sale}', [PosController::class, 'salesShow'])->name('sales-show');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::get('/{product}/download-barcode', [ProductController::class, 'downloadBarcode'])->name('download-barcode');
    });
});