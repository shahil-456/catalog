<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageServeController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\CatalogController;
use App\Http\Controllers\User\SaleController;


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('/serve/{path}', [ImageServeController::class, 'serve'])
    ->where('path', '.*')
    ->name('image.serve');


Route::get('/', function () {
        return redirect()->route('catalogs');

});



Route::get('catalogs', [CatalogController::class, 'index'])->name('catalogs');
Route::get('/catalogs/{catalogId}/products', [CatalogController::class, 'getProducts']) ->name('catalog.products');
Route::get('delete-product/{id}', [ProductController::class, 'destroy'])->name('product.delete');
Route::get('store-sale/{id}', [SaleController::class, 'store'])->name('sale.store');
Route::get('report', [SaleController::class, 'report'])->name('reports');
