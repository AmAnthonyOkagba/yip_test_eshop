@extends('layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>Manage Orders</h1>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>
                            {{ $order->user->name }}<br>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <form action="/admin/orders/{{ $order->id }}/status" method="POST" class="d-flex gap-2">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm">
                                    <option value="pending" @if($order->status === 'pending') selected @endif>Pending</option>
                                    <option value="processing" @if($order->status === 'processing') selected @endif>Processing</option>
                                    <option value="completed" @if($order->status === 'completed') selected @endif>Completed</option>
                                    <option value="cancelled" @if($order->status === 'cancelled') selected @endif>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                            </form>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y H:i A') }}</td>
                        <td>
                            <a href="/orders/{{ $order->id }}" class="btn btn-sm btn-outline-info">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No orders found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
