<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::view('/gesture-login', 'cashier.gesture-login')->name('gesture-login');
    Route::view('/pos', 'cashier.pos')->name('pos');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');

        Route::get('/{product}/download-barcode', [ProductController::class, 'downloadBarcode'])
            ->name('download-barcode');
    });
});