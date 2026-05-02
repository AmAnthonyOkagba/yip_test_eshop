@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="/products" class="btn btn-outline-secondary">← Back to Products</a>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <img src="https://via.placeholder.com/500x500?text={{ urlencode($product->name) }}" class="img-fluid mb-3" alt="{{ $product->name }}">
    </div>

    <div class="col-md-7">
        <h1>{{ $product->name }}</h1>

        <div class="mb-3">
            <span class="badge bg-primary">{{ $product->category->name }}</span>
            @if($product->stock > 0)
                <span class="badge bg-success">In Stock ({{ $product->stock }})</span>
            @else
                <span class="badge bg-danger">Out of Stock</span>
            @endif
        </div>

        <div class="price mb-3" style="font-size: 2rem;">${{ number_format($product->price, 2) }}</div>

        <div class="product-description mb-4">
            <h5>Description</h5>
            <p>{{ $product->description }}</p>
        </div>

        @if($product->stock > 0)
            <form action="/cart/add" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="max-width: 100px;">
                </div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
            </form>
        @else
            <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
        @endif

        <div class="mt-5 pt-4 border-top">
            <h5>Product Information</h5>
            <table class="table table-sm">
                <tr>
                    <td><strong>SKU:</strong></td>
                    <td>{{ $product->sku }}</td>
                </tr>
                <tr>
                    <td><strong>Category:</strong></td>
                    <td>{{ $product->category->name }}</td>
                </tr>
                <tr>
                    <td><strong>Availability:</strong></td>
                    <td>
                        @if($product->stock > 0)
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-danger">Not Available</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@if($relatedProducts->count() > 0)
    <div class="row mt-5 pt-4 border-top">
        <div class="col-md-12">
            <h3>Related Products</h3>
        </div>
        @foreach($relatedProducts as $related)
            <div class="col-sm-6 col-lg-3 mb-4">
                <div class="card product-card h-100">
                    <img src="https://via.placeholder.com/300x250?text={{ urlencode($related->name) }}" class="card-img-top product-image" alt="{{ $related->name }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $related->name }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($related->description, 60) }}</p>
                        <div class="mt-auto">
                            <div class="price mb-3">${{ number_format($related->price, 2) }}</div>
                            <div class="d-grid gap-2">
                                <a href="/products/{{ $related->id }}" class="btn btn-primary btn-custom">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
