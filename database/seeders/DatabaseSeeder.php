<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder 
{
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {
        // ==========================================
        // 1. Seed Users (Admin & Staff)
        // ==========================================
        User::updateOrCreate(
            ['email' => 'admin@saristore.com'],
            [
                'name' => 'Owner Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@saristore.com'],
            [
                'name' => 'Store Helper',
                'password' => Hash::make('staff123'),
                'role' => 'staff',
            ]
        );

        // ==========================================
        // 2. Seed Sample Products (Nakabase sa HeidiSQL Structure)
        // ==========================================
        $products = [
            [
                'name' => 'Lucky Me Chicken Noodles',
                'category' => 'Instant Noodles',
                'price' => 10.00,
                'stock_quantity' => 20,
                'reorder_threshold' => 20,
            ],
            [
                'name' => 'SkyFlakes Crackers',
                'category' => 'Snacks',
                'price' => 12.00,
                'stock_quantity' => 15,
                'reorder_threshold' => 3,
            ],
            [
                'name' => 'Coca-Cola',
                'category' => 'Beverages',
                'price' => 85.00,
                'stock_quantity' => 25,
                'reorder_threshold' => 5,
            ],
            [
                'name' => 'Sardines',
                'category' => 'Canned Goods',
                'price' => 25.00,
                'stock_quantity' => 15,
                'reorder_threshold' => 10,
            ],
            [
                'name' => 'Corned Beef',
                'category' => 'Canned Goods',
                'price' => 29.00,
                'stock_quantity' => 10,
                'reorder_threshold' => 5,
            ],
        ];

        foreach ($products as $productData) {
            Product::updateOrCreate(
                ['name' => $productData['name']],
                $productData
            );
        }
    }
}