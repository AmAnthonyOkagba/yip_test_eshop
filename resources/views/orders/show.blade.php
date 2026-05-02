@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="/my-orders" class="btn btn-outline-secondary">← Back to Orders</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Order #{{ $order->id }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6>Order Date</h6>
                        <p>{{ $order->created_at->format('M d, Y H:i A') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Status</h6>
                        <p>
                            @if($order->status === 'pending')
                                <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                            @elseif($order->status === 'processing')
                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                            @elseif($order->status === 'completed')
                                <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                            @else
                                <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                <h6 class="mt-4 mb-3">Items Ordered</h6>
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
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Shipping Address</h5>
            </div>
            <div class="card-body">
                <p>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping:</span>
                    <span>$0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Tax:</span>
                    <span>$0.00</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total:</strong>
                    <strong style="font-size: 1.3rem; color: #0d6efd;">${{ number_format($order->total_amount, 2) }}</strong>
                </div>

                @if($order->notes)
                    <hr>
                    <h6>Order Notes</h6>
                    <p class="text-muted">{{ $order->notes }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
