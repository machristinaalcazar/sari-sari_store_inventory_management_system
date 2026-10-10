<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\StockApiController;
use App\Http\Controllers\Api\SalesApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Fallback GET route para sa /api/login
Route::get('/login', function () {
    return response()->json([
        'status' => 'error',
        'message' => 'The GET method is not supported for api/login. Please send a POST request with email and password in the request body.',
    ], 405);
});

// Public Auth Route (POST)
Route::post('/login', [AuthApiController::class, 'login']);

// ==========================================
// PUBLIC GET ENDPOINTS (Mabubuksan sa Browser)
// ==========================================
Route::get('/products', [ProductApiController::class, 'index'])->name('api.products.index');
Route::get('/products/{product}', [ProductApiController::class, 'show'])->name('api.products.show');
Route::get('/inventory/low-stock', [StockApiController::class, 'lowStock']);
Route::get('/inventory/restock', [StockApiController::class, 'index']); // GET Method para sa Restock History
Route::get('/sales', [SalesApiController::class, 'index']);

// ==========================================
// PROTECTED API ROUTES (Nangangailangan ng Sanctum Token)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth Logout
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // Inventory Restock Action
    Route::post('/inventory/restock', [StockApiController::class, 'restock']);

    // Product Write Operations (POST, PUT, DELETE)
    Route::post('/products', [ProductApiController::class, 'store'])->name('api.products.store');
    Route::put('/products/{product}', [ProductApiController::class, 'update'])->name('api.products.update');
    Route::delete('/products/{product}', [ProductApiController::class, 'destroy'])->name('api.products.destroy');

    // Sales Store Action
    Route::post('/sales', [SalesApiController::class, 'store']);
});