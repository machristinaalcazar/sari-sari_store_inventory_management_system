<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Api\ProductApiController;

// ==========================================
// PUBLIC AUTHENTICATION & REGISTRATION ROUTES
// ==========================================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Google Authentication Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

// Google Role Selection Routes
Route::get('/auth/google/role', [GoogleAuthController::class, 'showRoleSelection'])->name('auth.google.role');
Route::post('/auth/google/role', [GoogleAuthController::class, 'storeRole'])->name('auth.google.role.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// PROTECTED ROUTES
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::resource('users', UserController::class);
            
            // Resource Route for Products (Properly prefixed and named within admin group)
            Route::resource('products', ProductController::class)->names([
                'index'   => 'products.index',
                'create'  => 'products.create',
                'store'   => 'products.store',
                'show'    => 'products.show',
                'edit'    => 'products.edit',
                'update'  => 'products.update',
                'destroy' => 'products.destroy',
            ]);

            // API Product list para sa Admin UI / Dashboard (Accessible via Web Session)
            Route::get('/products-list', [ProductApiController::class, 'index']);

            Route::get('/stock-in', [StockInController::class, 'create'])->name('stock_in.create');
            Route::post('/stock-in', [StockInController::class, 'store'])->name('stock_in.store');
            Route::get('/sales-report', [SaleController::class, 'index'])->name('sales.index');
        });

    // Staff Routes
    Route::middleware(['role:staff'])
        ->prefix('staff')
        ->name('staff.')
        ->group(function () {
            Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        });

    // Shared Sales Entry Route
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

});