@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>My Orders</h1>
        <p class="text-muted">View and manage your orders</p>
    </div>
</div>

@if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->items->count() }} item(s)</td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            @if($order->status === 'pending')
                                <span class="badge bg-warning">{{ ucfirst($order->status) }}</span>
                            @elseif($order->status === 'processing')
                                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                            @elseif($order->status === 'completed')
                                <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                            @else
                                <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="/orders/{{ $order->id }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@else
    <div class="alert alert-info text-center py-5">
        <h4>No Orders Yet</h4>
        <p>You haven't placed any orders yet. Start shopping now!</p>
        <a href="/products" class="btn btn-primary">Browse Products</a>
    </div>
@endif
@endsection
