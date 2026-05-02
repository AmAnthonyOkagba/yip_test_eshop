@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>Admin Dashboard</h1>
        <p class="text-muted">Welcome to your admin panel</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Total Orders</h6>
                <h2>{{ $totalOrders }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Total Revenue</h6>
                <h2>${{ number_format($totalRevenue, 2) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title">Total Products</h6>
                <h2>{{ $totalProducts }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6 class="card-title">Pending Orders</h6>
                <h2>{{ $recentOrders->where('status', 'pending')->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
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
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="/admin/orders" class="btn btn-sm btn-outline-primary">Manage</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No orders yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="/admin/products" class="list-group-item list-group-item-action">📦 Manage Products</a>
                <a href="/admin/products/create" class="list-group-item list-group-item-action">➕ Add New Product</a>
                <a href="/admin/orders" class="list-group-item list-group-item-action">📋 Manage Orders</a>
            </div>
        </div>
    </div>
</div>
@endsection
