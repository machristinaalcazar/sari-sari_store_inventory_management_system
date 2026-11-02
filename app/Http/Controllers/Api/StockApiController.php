<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockApiController extends Controller
{
    // GET /api/inventory/restock
    public function index()
    {
        $stocks = StockIn::with('product')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $stocks,
        ], 200);
    }

    // GET /api/inventory/low-stock
    public function lowStock()
    {
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'reorder_threshold')->get();

        return response()->json([
            'status' => 'success',
            'data' => $lowStockProducts,
        ], 200);
    }

    // POST /api/inventory/restock
    public function restock(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'supplier' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $stockIn = StockIn::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'user_id' => $request->user()->id ?? null,
                'supplier' => $validated['supplier'] ?? null,
            ]);

            $product = Product::findOrFail($validated['product_id']);
            $product->increment('stock_quantity', $validated['quantity']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Stock added successfully',
                'data' => $stockIn->load('product'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add stock',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}