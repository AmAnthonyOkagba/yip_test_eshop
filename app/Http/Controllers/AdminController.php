<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user() || !Auth::user()->isAdmin()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');
        $totalProducts = Product::count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        return view('admin.dashboard', compact('totalOrders', 'totalRevenue', 'totalProducts', 'recentOrders'));
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate(['status' => 'required|in:pending,processing,completed,cancelled']);
        $order = Order::findOrFail($orderId);
        $order->status = $request->status;
        if ($request->status === 'completed') {
            $order->shipped_at = now();
        }
        $order->save();
        return redirect()->back()->with('success', 'Order status updated!');
    }

    public function products()
    {
        $products = Product::with('category')->latest()->paginate(20);
        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.product-form', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|unique:products',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products');
        }
        Product::create($data);
        return redirect('/admin/products')->with('success', 'Product created!');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product-form', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products');
        }
        $product->update($data);
        return redirect('/admin/products')->with('success', 'Product updated!');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Product deleted!');
    }
}
