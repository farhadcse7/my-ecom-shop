<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\WebsiteController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;

//Website Route list
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/product-category', [WebsiteController::class, 'category'])->name('category');
Route::get('/product-detail', [WebsiteController::class, 'product'])->name('product-detail');

Route::get('/show-cart', [CartController::class, 'index'])->name('show-cart');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

//Admin Route List
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Category (Normal)
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    //Sub Category (Resource)
    Route::resource('sub-category', SubCategoryController::class);


});
