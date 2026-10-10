<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller {
    public function index() {
        $sales = Sale::with(['user', 'items.product'])->orderBy('created_at', 'desc')->paginate(15);
        $dailyTotal = Sale::whereDate('created_at', now()->today())->sum('total_amount');
        return view('sales.index', compact('sales', 'dailyTotal'));
    }

    public function create() {
        $products = Product::where('stock_quantity', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request) {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'total_amount' => 0,
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock_quantity', $item['quantity']);
            }

            $sale->update(['total_amount' => $totalAmount]);
        });

        $redirectRoute = Auth::user()->role === 'admin' ? 'admin.sales.index' : 'staff.dashboard';
        return redirect()->route($redirectRoute)->with('success', 'Sale completed successfully.');
    }
}