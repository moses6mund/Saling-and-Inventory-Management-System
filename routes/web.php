<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\OrderDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes


Auth::routes();

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard route
    
    
    
    // Admin only routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::resource('users', UserController::class);
        // Route::resource('/transactions', TransactionController::class);
        Route::resource('/sellings', OrderDetailController::class);
        Route::resource('/products', ProductController::class);
        Route::resource('/suppliers', SupplierController::class);
        // Route::resource('/companies', CompanyController::class);
        Route::get('/profit', [OrderController::class, 'profit'])->name('profit.index');
        Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::post('product-import', [ProductController::class,'import'])->name('products.import');
        Route::get('product-export', [ProductController::class, 'exports'])->name('products.export'); 
        Route::post('order-import', [OrderDetailController::class,'orderDetailImport'])->name('orders.import');
        Route::get('order-export', [OrderDetailController::class, 'orderDetailExport'])->name('orders.export');
    });
    
    // Both admin and regular users
    Route::resource('/orders', OrderController::class);
    Route::get('/report/daily', [OrderController::class, 'dailyReport'])->name('reports.index');
    
    // Welcome route for cashiers
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');
    
});



