<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\SalesApiController;
use App\Http\Controllers\API\StockApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ==========================================
// 1. Public Authentication Routes
// ==========================================
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);

// ==========================================
// 2. Public Product Read Routes
// ==========================================
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{id}', [ProductApiController::class, 'show']);

// ==========================================
// 3. Authenticated Routes (Requires valid Sanctum Token)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth Profile & Logout Endpoints
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/profile', [ApiAuthController::class, 'profile']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Product Management (Mutations restricted to Admin via middleware or gate)
    Route::middleware('role:admin')->group(function () {
        Route::post('/products', [ProductApiController::class, 'store']);
        Route::match(['put', 'patch'], '/products/{id}', [ProductApiController::class, 'update']);
        Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);
    });

    // Sales Endpoints
    Route::get('/sales', [SalesApiController::class, 'index']);
    Route::post('/sales', [SalesApiController::class, 'store']);

    // Inventory / Stock Endpoints
    Route::get('/inventory/restock', [StockApiController::class, 'index']);
    Route::get('/inventory/low-stock', [StockApiController::class, 'lowStock']);
    Route::post('/inventory/restock', [StockApiController::class, 'restock']);

    // Admin Only Endpoints Group
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Welcome Admin']);
        });
    });

    // Staff Endpoints Group (Accessible by Staff and Admin based on your User model logic)
    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/inventory', function () {
            return response()->json(['message' => 'Staff Inventory Access Granted']);
        });
    });
});