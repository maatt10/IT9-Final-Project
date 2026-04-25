<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});     

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Manage Sales
Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);

// Inventory Management
Route::resource('inventory', ProductController::class);