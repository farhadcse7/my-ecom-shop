<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\WebsiteController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;

//Website Route list
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/category', [WebsiteController::class, 'category'])->name('category');
Route::get('/product-detail',[WebsiteController::class, 'product'])->name('product-detail');

Route::get('/show-cart',[CartController::class, 'index'])->name('show-cart');
Route::get('/checkout',[CheckoutController::class, 'index'])->name('checkout');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
