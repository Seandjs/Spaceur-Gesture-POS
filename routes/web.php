<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::view('/gesture-login', 'cashier.gesture-login')->name('gesture-login');
    Route::view('/pos', 'cashier.pos')->name('pos');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('products')->name('products.')->group(function () {
        Route::view('/', 'admin.products.index')->name('index');
        Route::view('/create', 'admin.products.create')->name('create');
    });
});