<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

// Home
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{categoryId}', [ProductController::class, 'byCategory'])->name('products.byCategory');

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Cart
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{itemId}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
});

// Checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order-confirmation/{orderId}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
});

// Orders
Route::middleware('auth')->group(function () {
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.myOrders');
    Route::get('/orders/{orderId}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::put('/orders/{orderId}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.updateOrderStatus');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.createProduct');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.storeProduct');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.editProduct');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.updateProduct');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.deleteProduct');
});

