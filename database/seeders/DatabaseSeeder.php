<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create([
            'name' => 'Owner Admin',
            'email' => 'admin@saristore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Store Helper',
            'email' => 'staff@saristore.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
        ]);

        Product::create(['name' => 'Canned Sardines 155g', 'category' => 'Canned Goods', 'price' => 22.00, 'stock_quantity' => 15, 'reorder_threshold' => 5]);
        Product::create(['name' => 'Instant Noodles Beef', 'category' => 'Noodles', 'price' => 15.00, 'stock_quantity' => 3, 'reorder_threshold' => 5]);
        Product::create(['name' => 'Sachet Laundry Powder', 'category' => 'Household', 'price' => 12.00, 'stock_quantity' => 2, 'reorder_threshold' => 5]);
    }
}