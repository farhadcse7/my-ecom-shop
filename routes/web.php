<?php

use App\Http\Middleware\CustomerMiddleware;
use Illuminate\Support\Facades\Route;

//frontend
use App\Http\Controllers\Frontend\WebsiteController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\CustomerProfileController;

//backend
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\CourierController;

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
Route::post('/checkout/new-order', [CheckoutController::class, 'newOrder'])->name('checkout.new-order'); //save order info using post
Route::get('/checkout/complete-order', [CheckoutController::class, 'completeOrder'])->name('checkout.complete-order'); //Order info save successfully.- message will show

//Customer Auth
Route::get('/customer/register', [CustomerAuthController::class, 'register'])->name('customer.register');
Route::post('/customer/store', [CustomerAuthController::class, 'newCustomer'])->name('customer.store');
Route::get('/customer/login', [CustomerAuthController::class, 'login'])->name('customer.login');
Route::post('/customer/login', [CustomerAuthController::class, 'loginCheck'])->name('customer.login');
Route::get('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

//Customer Profile
Route::middleware([CustomerMiddleware::class])->group(function () {
    Route::get('/customer/dashboard', [CustomerAuthController::class, 'dashboard'])->name('customer.dashboard'); //used CustomerAuthController
    Route::get('/customer/profile', [CustomerProfileController::class, 'index'])->name('customer.profile');
    Route::get('/customer/order', [CustomerProfileController::class, 'order'])->name('customer.order');
    Route::get('/customer/payment', [CustomerProfileController::class, 'payment'])->name('customer.payment');
    Route::get('/customer/change-password', [CustomerProfileController::class, 'changePassword'])->name('customer.change-password');
    Route::post('/customer/update-password', [CustomerProfileController::class, 'updatePassword'])->name('customer.update-password');
});

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

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

    //Admin Order
    Route::get('/admin-order/index', [AdminOrderController::class, 'index'])->name('admin-order.index');
    Route::get('/admin-order/detail/{id}', [AdminOrderController::class, 'detail'])->name('admin-order.detail');
    Route::get('/admin-order/edit/{id}', [AdminOrderController::class, 'edit'])->name('admin-order.edit');
    Route::post('/admin-order/update/{id}', [AdminOrderController::class, 'update'])->name('admin-order.update');
    Route::get('/admin-order/show-invoice/{id}', [AdminOrderController::class, 'showInvoice'])->name('admin-order.show-invoice');
    Route::get('/admin-order/download-invoice/{id}', [AdminOrderController::class, 'downloadInvoice'])->name('admin-order.download-invoice');
    Route::get('/admin-order/destroy/{id}', [AdminOrderController::class, 'destroy'])->name('admin-order.destroy');

    //Courier (Resource)
    Route::resource('courier', CourierController::class);

});
