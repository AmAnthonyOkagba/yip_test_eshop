<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = Auth::user()->cart()->with('items.product')->first();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cart = $user->cart()->firstOrCreate();
        $product = Product::find($request->product_id);

        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        $cart->updateTotal();
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove($itemId)
    {
        $cartItem = CartItem::findOrFail($itemId);
        $cart = $cartItem->cart;
        $cartItem->delete();
        $cart->updateTotal();
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem = CartItem::findOrFail($itemId);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        $cartItem->cart->updateTotal();
        return redirect()->back()->with('success', 'Quantity updated!');
    }
}
