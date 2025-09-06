<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\LoginController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\CategoryController;


Route::get('/customer', function () {
    return 'Hello Customer!';
})->name('customer');


