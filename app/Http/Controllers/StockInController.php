<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller {
    public function create() {
        $products = Product::all();
        return view('stock_in.create', compact('products'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'supplier' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validated) {
            StockIn::create($validated);
            $product = Product::findOrFail($validated['product_id']);
            $product->increment('stock_quantity', $validated['quantity']);
        });

        return redirect()->route('admin.dashboard')->with('success', 'Stock updated successfully.');
    }
}