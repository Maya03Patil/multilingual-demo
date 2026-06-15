<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

        // Storefront
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        
        // Product Management (Auto-Translates everything submitted here)
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        
        // Cart Routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    }
);
