<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Accessible by Admin & Staff
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'status'  => true,
            'message' => 'Products retrieved successfully',
            'data'    => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     * Accessible only by Admin
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'category'          => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'price'             => 'nullable|numeric|min:0',
            'unit_cost'         => 'nullable|numeric|min:0',
            'selling_price'     => 'nullable|numeric|min:0',
            'stock_quantity'    => 'required|integer|min:0',
            'reorder_level'     => 'nullable|integer|min:0',
            'reorder_threshold' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $product = Product::create($request->all());

        return response()->json([
            'success' => true,
            'status'  => true,
            'message' => 'Product created successfully',
            'data'    => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     * Accessible by Admin & Staff
     */
    public function show(int|string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'status'  => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'status'  => true,
            'message' => 'Product retrieved successfully',
            'data'    => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * Accessible only by Admin
     */
    public function update(Request $request, int|string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'status'  => false,
                'message' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'              => 'sometimes|required|string|max:255',
            'category'          => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'price'             => 'sometimes|nullable|numeric|min:0',
            'unit_cost'         => 'sometimes|nullable|numeric|min:0',
            'selling_price'     => 'sometimes|nullable|numeric|min:0',
            'stock_quantity'    => 'sometimes|required|integer|min:0',
            'reorder_level'     => 'nullable|integer|min:0',
            'reorder_threshold' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $product->update($request->all());

        return response()->json([
            'success' => true,
            'status'  => true,
            'message' => 'Product updated successfully',
            'data'    => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * Accessible only by Admin
     */
    public function destroy(int|string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'status'  => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'status'  => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }
}