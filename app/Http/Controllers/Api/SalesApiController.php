<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesApiController extends Controller
{
    // GET /api/sales
    public function index()
    {
        $sales = Sale::with('items.product')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $sales,
        ], 200);
    }

    // POST /api/sales
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;

            $sale = Sale::create([
                'user_id' => $request->user()->id ?? null,
                'total_amount' => 0,
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->quantity < $item['quantity']) {
                    DB::rollBack();
                    return response()->json([
                        'status' => 'error',
                        'message' => "Insufficient stock for product: {$product->name}",
                    ], 400);
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('quantity', $item['quantity']);
            }

            $sale->update(['total_amount' => $totalAmount]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sale recorded successfully',
                'data' => $sale->load('items'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Transaction failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}