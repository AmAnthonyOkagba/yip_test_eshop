<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic gadgets and devices'],
            ['name' => 'Clothing', 'description' => 'Fashion and apparel items'],
            ['name' => 'Books', 'description' => 'Educational and recreational books'],
            ['name' => 'Home & Garden', 'description' => 'Home improvement and garden supplies'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                'name' => $cat['name'],
                'description' => $cat['description'],
                'slug' => Str::slug($cat['name']),
                'is_active' => true,
                ]
            );
        }

        // Get categories
        $electronics = Category::where('name', 'Electronics')->first();
        $clothing = Category::where('name', 'Clothing')->first();
        $books = Category::where('name', 'Books')->first();
        $homeGarden = Category::where('name', 'Home & Garden')->first();

        // Create Products
        $products = [
            // Electronics
            ['name' => 'Wireless Headphones', 'description' => 'High-quality wireless headphones with noise cancellation', 'price' => 149.99, 'stock' => 50, 'category' => $electronics, 'sku' => 'WH-001'],
            ['name' => 'USB-C Charger', 'description' => 'Fast charging USB-C charger for all devices', 'price' => 29.99, 'stock' => 100, 'category' => $electronics, 'sku' => 'CHG-001'],
            ['name' => 'Portable Phone Stand', 'description' => 'Adjustable phone stand for desk and table', 'price' => 19.99, 'stock' => 75, 'category' => $electronics, 'sku' => 'STD-001'],
            ['name' => 'Wireless Mouse', 'description' => 'Ergonomic wireless mouse with long battery life', 'price' => 34.99, 'stock' => 60, 'category' => $electronics, 'sku' => 'MSE-001'],

            // Clothing
            ['name' => 'Cotton T-Shirt', 'description' => 'Comfortable 100% cotton t-shirt available in multiple colors', 'price' => 19.99, 'stock' => 150, 'category' => $clothing, 'sku' => 'TSH-001'],
            ['name' => 'Denim Jeans', 'description' => 'Classic blue denim jeans with perfect fit', 'price' => 59.99, 'stock' => 80, 'category' => $clothing, 'sku' => 'JNS-001'],
            ['name' => 'Winter Jacket', 'description' => 'Warm and stylish winter jacket for cold weather', 'price' => 129.99, 'stock' => 40, 'category' => $clothing, 'sku' => 'JCK-001'],
            ['name' => 'Sports Shoes', 'description' => 'Professional sports shoes with excellent cushioning', 'price' => 89.99, 'stock' => 70, 'category' => $clothing, 'sku' => 'SHO-001'],

            // Books
            ['name' => 'Laravel for Beginners', 'description' => 'Complete guide to learning Laravel framework', 'price' => 39.99, 'stock' => 30, 'category' => $books, 'sku' => 'BK-LAR-001'],
            ['name' => 'PHP Programming', 'description' => 'Comprehensive PHP programming guide with examples', 'price' => 44.99, 'stock' => 25, 'category' => $books, 'sku' => 'BK-PHP-001'],
            ['name' => 'E-commerce Development', 'description' => 'Guide to building modern e-commerce platforms', 'price' => 54.99, 'stock' => 20, 'category' => $books, 'sku' => 'BK-ECOM-001'],
            ['name' => 'Web Design Principles', 'description' => 'Learn professional web design principles and practices', 'price' => 34.99, 'stock' => 35, 'category' => $books, 'sku' => 'BK-WEB-001'],

            // Home & Garden
            ['name' => 'LED Desk Lamp', 'description' => 'Modern LED desk lamp with adjustable brightness', 'price' => 44.99, 'stock' => 45, 'category' => $homeGarden, 'sku' => 'LMP-001'],
            ['name' => 'Plant Pot Set', 'description' => 'Set of 3 ceramic plant pots with drainage', 'price' => 34.99, 'stock' => 55, 'category' => $homeGarden, 'sku' => 'POT-001'],
            ['name' => 'Wall Shelves', 'description' => 'Set of 2 floating wall shelves for storage', 'price' => 54.99, 'stock' => 35, 'category' => $homeGarden, 'sku' => 'SHF-001'],
            ['name' => 'Garden Tool Set', 'description' => 'Complete garden tool set with carrying case', 'price' => 69.99, 'stock' => 25, 'category' => $homeGarden, 'sku' => 'TLS-001'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['sku' => $product['sku']],
                [
                    'category_id' => $product['category']->id,
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'sku' => $product['sku'],
                    'is_active' => true,
                ]
            );
        }

        // Create users
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
            'name' => 'Admin User',
            'password' => bcrypt('Password123!'),
            'role' => 'admin',
            'phone' => '555-1234',
            'address' => '123 Admin Street',
            'city' => 'Admin City',
            'state' => 'AS',
            'zip_code' => '12345',
            ]
        );

        $customerUser = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Demo Customer',
                'password' => bcrypt('Password123!'),
                'role' => 'user',
                'phone' => '555-2222',
                'address' => '456 Customer Lane',
                'city' => 'Shopville',
                'state' => 'SV',
                'zip_code' => '67890',
            ]
        );

        // Seed a sample cart for demo customer
        $cart = Cart::firstOrCreate(
            ['user_id' => $customerUser->id],
            ['total_amount' => 0]
        );

        $cartProducts = Product::whereIn('sku', ['WH-001', 'TSH-001'])->get()->keyBy('sku');

        if (isset($cartProducts['WH-001'])) {
            CartItem::updateOrCreate(
                ['cart_id' => $cart->id, 'product_id' => $cartProducts['WH-001']->id],
                ['quantity' => 1]
            );
        }

        if (isset($cartProducts['TSH-001'])) {
            CartItem::updateOrCreate(
                ['cart_id' => $cart->id, 'product_id' => $cartProducts['TSH-001']->id],
                ['quantity' => 2]
            );
        }

        $cart->updateTotal();

        // Seed a sample completed order with order items
        $order = Order::firstOrCreate(
            ['user_id' => $customerUser->id, 'notes' => 'Seeded demo order'],
            [
                'total_amount' => 0,
                'status' => 'completed',
                'shipping_address' => $customerUser->address,
                'shipping_city' => $customerUser->city,
                'shipping_state' => $customerUser->state,
                'shipping_zip' => $customerUser->zip_code,
                'shipped_at' => now()->subDay(),
            ]
        );

        // Keep seeded demo order deterministic on re-run.
        $order->items()->delete();

        $orderProducts = Product::whereIn('sku', ['CHG-001', 'BK-LAR-001'])->get()->keyBy('sku');
        $orderTotal = 0;

        if (isset($orderProducts['CHG-001'])) {
            $quantity = 2;
            $price = (float) $orderProducts['CHG-001']->price;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $orderProducts['CHG-001']->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
            $orderTotal += $price * $quantity;
        }

        if (isset($orderProducts['BK-LAR-001'])) {
            $quantity = 1;
            $price = (float) $orderProducts['BK-LAR-001']->price;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $orderProducts['BK-LAR-001']->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);
            $orderTotal += $price * $quantity;
        }

        $order->update(['total_amount' => $orderTotal]);
    }
}

