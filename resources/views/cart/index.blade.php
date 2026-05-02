@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>Shopping Cart</h1>
    </div>
</div>

@if($cart && $cart->items->count() > 0)
    <div class="row">
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart->items as $item)
                            <tr>
                                <td>
                                    <a href="/products/{{ $item->product->id }}" class="text-decoration-none">
                                        {{ $item->product->name }}
                                    </a>
                                </td>
                                <td>${{ number_format($item->product->price, 2) }}</td>
                                <td>
                                    <form action="/cart/update/{{ $item->id }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width: 80px;" required>
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Update</button>
                                    </form>
                                </td>
                                <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                <td>
                                    <form action="/cart/remove/{{ $item->id }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($cart->total_amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span>$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span>$0.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total:</strong>
                        <strong style="font-size: 1.5rem; color: #0d6efd;">${{ number_format($cart->total_amount, 2) }}</strong>
                    </div>
                    <a href="/checkout" class="btn btn-primary w-100 btn-lg">Proceed to Checkout</a>
                    <a href="/products" class="btn btn-outline-secondary w-100 mt-2">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info text-center py-5">
        <h4>Your cart is empty</h4>
        <p>Start shopping to add items to your cart</p>
        <a href="/products" class="btn btn-primary">Browse Products</a>
    </div>
@endif
@endsection
