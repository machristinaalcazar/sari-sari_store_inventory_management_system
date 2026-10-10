<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller {
    public function index(Request $request) {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        $products = $query->orderBy('name')->get();
        return view('staff.dashboard', compact('products'));
    }
}