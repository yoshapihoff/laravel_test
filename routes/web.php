<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products/all', [ProductController::class, 'index']);
Route::get('/products', [ProductController::class, 'filteredIndex']);
Route::get('/generate/products', [ProductController::class, 'generate']);
