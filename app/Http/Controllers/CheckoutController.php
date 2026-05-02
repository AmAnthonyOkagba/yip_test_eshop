<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();
        if (!$cart || $cart->items->count() === 0) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }
        return view('checkout.index', compact('user', 'cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_state' => 'required|string',
            'shipping_zip' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->count() === 0) {
            return redirect('/cart')->with('error', 'Your cart is empty!');
        }

        DB::transaction(function () use ($request, $user, $cart) {
            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $cart->total_amount,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zip' => $request->shipping_zip,
                'notes' => $request->notes,
            ]);

            // Add order items and decrement stock
            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
                $cartItem->product->decrementStock($cartItem->quantity);
            }

            // Clear cart
            $cart->items()->delete();
            $cart->total_amount = 0;
            $cart->save();
        });

        return redirect('/order-confirmation/' . $order->id)->with('success', 'Order placed successfully!');
    }

    public function confirmation($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('checkout.confirmation', compact('order'));
    }
}
