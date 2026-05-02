@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-success mb-4">
            <div class="card-header bg-success text-white">
                <h2 class="mb-0 text-center">✓ Order Confirmed!</h2>
            </div>
            <div class="card-body text-center py-5">
                <h4 class="mb-3">Thank you for your purchase</h4>
                <p class="text-muted">Your order has been successfully placed and you will receive a confirmation email shortly.</p>

                <h5 class="mt-4 mb-3">Order Details</h5>
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Order Number:</strong></td>
                        <td>#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Order Date:</strong></td>
                        <td>{{ $order->created_at->format('M d, Y H:i A') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td><span class="badge bg-warning">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Total Amount:</strong></td>
                        <td><strong style="color: #0d6efd; font-size: 1.2rem;">${{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                </table>

                <h5 class="mt-4 mb-3">Shipping Address</h5>
                <p>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}
                </p>

                <h5 class="mt-4 mb-3">Order Items</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="/my-orders" class="btn btn-primary">View My Orders</a>
                    <a href="/products" class="btn btn-outline-secondary">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
