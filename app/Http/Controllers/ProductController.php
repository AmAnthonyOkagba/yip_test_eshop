<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $products = Product::where('is_active', true)->paginate(12);
        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->where('is_active', true)
            ->limit(4)
            ->get();
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function byCategory($categoryId)
    {
        $category = Category::where('is_active', true)->findOrFail($categoryId);
        $products = $category->products()->where('is_active', true)->paginate(12);
        $categories = Category::where('is_active', true)->get();
        return view('products.index', compact('products', 'categories', 'category'));
    }
}
