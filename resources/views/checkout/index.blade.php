@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h1>Checkout</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Shipping Information</h5>
            </div>
            <div class="card-body">
                <form action="/checkout/process" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" value="{{ explode(' ', $user->name)[0] }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" value="{{ implode(' ', array_slice(explode(' ', $user->name), 1)) }}" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                    </div>

                    <h6 class="mt-4 mb-3">Shipping Address</h6>

                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Street Address *</label>
                        <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" value="{{ old('shipping_address', $user->address) }}" required>
                        @error('shipping_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="shipping_city" class="form-label">City *</label>
                            <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" id="shipping_city" name="shipping_city" value="{{ old('shipping_city', $user->city) }}" required>
                            @error('shipping_city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="shipping_state" class="form-label">State/Province *</label>
                            <input type="text" class="form-control @error('shipping_state') is-invalid @enderror" id="shipping_state" name="shipping_state" value="{{ old('shipping_state', $user->state) }}" required>
                            @error('shipping_state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="shipping_zip" class="form-label">ZIP Code *</label>
                        <input type="text" class="form-control @error('shipping_zip') is-invalid @enderror" id="shipping_zip" name="shipping_zip" value="{{ old('shipping_zip', $user->zip_code) }}" required>
                        @error('shipping_zip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Order Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Add special instructions for your order"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg w-100">Complete Purchase</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Order Summary</h5>
            </div>
            <div class="card-body">
                <h6 class="mb-3">Items in Order:</h6>
                @foreach($cart->items as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                        <span>${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>${{ number_format($cart->total_amount, 2) }}</span>
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
                    <strong style="font-size: 1.3rem; color: #0d6efd;">${{ number_format($cart->total_amount, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
