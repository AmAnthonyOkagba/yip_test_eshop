<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - E-Commerce Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,.1); background-color: #fff; }
        .navbar-brand { font-weight: bold; color: #0d6efd !important; }
        .product-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .product-image { height: 250px; object-fit: cover; background-color: #e9ecef; }
        .price { font-size: 1.5rem; font-weight: bold; color: #0d6efd; }
        .btn-custom { border-radius: 5px; padding: 10px 20px; }
        footer { background-color: #212529; color: #fff; margin-top: 50px; padding: 30px 0; }
        .cart-icon { position: relative; }
        .cart-count { position: absolute; top: -8px; right: -8px; background-color: #dc3545; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.75rem; font-weight: bold; }
        .alert-dismissible .btn-close { padding: 0.5rem; }
        @media (max-width: 768px) {
            .product-card { margin-bottom: 15px; }
            .navbar-collapse { margin-top: 10px; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">🛍️ E-Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Admin</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="/my-orders">My Orders</a></li>
                        <li class="nav-item">
                            <a class="nav-link cart-icon" href="/cart">
                                🛒 Cart
                                @if(auth()->user()->cart && auth()->user()->cart->items->count() > 0)
                                    <span class="cart-count">{{ auth()->user()->cart->items->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="/logout" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="/cart">🛒 Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-primary text-white ms-2" href="/register">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Errors:</strong>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <main class="container my-5">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>About Us</h5>
                    <p>Your trusted online shopping destination for quality products at great prices.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="/products" class="text-white text-decoration-none">Products</a></li>
                        <li><a href="/cart" class="text-white text-decoration-none">Cart</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Contact</h5>
                    <p>Email: info@eshop.com<br>Phone: +1-234-567-8900</p>
                </div>
            </div>
            <hr class="bg-white">
            <div class="text-center">
                <p>&copy; 2026 E-Shop. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
