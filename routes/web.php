<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;

//Website Route list
Route::get('/', [WebsiteController::class, 'index'])->name('home');
