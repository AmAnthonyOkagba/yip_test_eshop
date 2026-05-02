@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>Shop Products</h1>
        <p class="text-muted">Browse our collection of quality products</p>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Categories</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="/products" class="list-group-item list-group-item-action @if(!isset($category)) active @endif">All Products</a>
                @foreach($categories as $cat)
                    <a href="/category/{{ $cat->id }}" class="list-group-item list-group-item-action @if(isset($category) && $category->id === $cat->id) active @endif">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-9">
        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                    <div class="col-sm-6 col-lg-4 mb-4">
                        <div class="card product-card h-100">
                            <img src="https://via.placeholder.com/300x250?text={{ urlencode($product->name) }}" class="card-img-top product-image" alt="{{ $product->name }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                                <div class="mt-auto">
                                    <div class="price mb-3">${{ number_format($product->price, 2) }}</div>
                                    <div class="d-grid gap-2">
                                        @if($product->stock > 0)
                                            <a href="/products/{{ $product->id }}" class="btn btn-primary btn-custom">View Details</a>
                                            <form action="/cart/add" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-outline-primary btn-custom w-100">Add to Cart</button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-custom" disabled>Out of Stock</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    {{ $products->links() }}
                </div>
            </div>
        @else
            <div class="alert alert-info">
                <h4>No Products Available</h4>
                <p>Sorry, there are no products in this category at the moment.</p>
            </div>
        @endif
    </div>
</div>
@endsection
