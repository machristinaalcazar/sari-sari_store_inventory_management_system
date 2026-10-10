<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Lab4ManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_can_be_created_with_role(): void
    {
        $user = User::create([
            'name' => 'Owner Admin',
            'email' => 'owner@example.com',
            'password' => 'secret123',
            'role' => 'admin',
        ]);

        $this->assertSame('admin', $user->role);
        $this->assertDatabaseHas('users', [
            'email' => 'owner@example.com',
            'role' => 'admin',
        ]);
    }

    public function test_product_uses_inventory_fields_expected_by_lab(): void
    {
        $product = Product::create([
            'name' => 'Canned Sardines',
            'category' => 'Canned Goods',
            'price' => 22.00,
            'stock_quantity' => 15,
            'reorder_threshold' => 5,
        ]);

        $this->assertSame(15, $product->stock_quantity);
        $this->assertDatabaseHas('products', [
            'name' => 'Canned Sardines',
            'stock_quantity' => 15,
            'reorder_threshold' => 5,
        ]);
    }
}
