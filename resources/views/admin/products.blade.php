@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h1>Manage Products</h1>
    </div>
    <div class="col-md-6 text-end">
        <a href="/admin/products/create" class="btn btn-success">➕ Add New Product</a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge @if($product->stock > 0) bg-success @else bg-danger @endif">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="/admin/products/{{ $product->id }}/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="/admin/products/{{ $product->id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
