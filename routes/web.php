<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\WebsiteController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;

use App\Http\Controllers\CustomerAuthController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ProductController;

//Website Route list
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/product-category/{id}', [WebsiteController::class, 'category'])->name('category');
Route::get('/product-sub-category/{id}', [WebsiteController::class, 'subCategory'])->name('sub-category');
Route::get('/product-detail/{id}', [WebsiteController::class, 'product'])->name('product-detail');

//Cart
Route::get('/cart/index', [CartController::class, 'index'])->name('cart.index'); //cart product list showing
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{rowId}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');

//Checkout
Route::get('/checkout/index', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/confirm-order', [CheckoutController::class, 'confirmOrder'])->name('checkout.confirm-order');
Route::post('/checkout/new-order', [CheckoutController::class, 'newOrder'])->name('checkout.new-order');
Route::get('/checkout/complete-order', [CheckoutController::class, 'completeOrder'])->name('checkout.complete-order');

//Customer Auth
Route::get('/customer/dashboard', [CustomerAuthController::class, 'dashboard'])->name('customer.dashboard');
Route::get('/customer/register', [CustomerAuthController::class, 'register'])->name('customer.register');
Route::post('/customer/store', [CustomerAuthController::class, 'newCustomer'])->name('customer.store');
Route::get('/customer/login', [CustomerAuthController::class, 'login'])->name('customer.login');
Route::post('/customer/login', [CustomerAuthController::class, 'loginCheck'])->name('customer.login');
Route::get('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

//Admin Route List
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Category (Normal)
    Route::get('/category/index', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    //Sub Category (Resource)
    Route::resource('sub-category', SubCategoryController::class);

    //Brand (Resource)
    Route::resource('brand', BrandController::class);

    //Unit (Resource)
    Route::resource('unit', UnitController::class);

    //Product (Resource)
    Route::resource('product', ProductController::class);
    //route for dynamically get product subcategory according to category
    Route::get('/get-sub-category-by-category', [ProductController::class, 'getSubCategoryByCategory'])->name('get-sub-category-by-category');


});
