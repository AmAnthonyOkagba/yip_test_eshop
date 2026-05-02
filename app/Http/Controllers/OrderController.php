<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function myOrders()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->paginate(10);
        return view('orders.my-orders', compact('orders'));
    }

    public function show($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('orders.show', compact('order'));
    }
}
