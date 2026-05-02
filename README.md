# 🛍️ E-Commerce Platform - Complete Solution

A fully functional, production-ready e-commerce platform built with **Laravel 13**, featuring product management, shopping cart, secure checkout, user authentication, and admin dashboard.

## ✨ Features

### 🛒 Customer Features
- ✅ Browse products by category
- ✅ View detailed product information with related products
- ✅ Add/remove items from shopping cart
- ✅ Secure checkout with shipping address
- ✅ Order history and tracking
- ✅ User registration and login
- ✅ Mobile-responsive design

### 👨‍💼 Admin Features  
- ✅ Dashboard with key metrics (orders, revenue, products)
- ✅ Product management (Create, Read, Update, Delete)
- ✅ Inventory management
- ✅ Order management and status tracking
- ✅ Customer order details

### 🎨 Design & UX
- ✅ Bootstrap 5 responsive design
- ✅ Mobile-first approach
- ✅ Intuitive user interface
- ✅ Touch-friendly components
- ✅ Fast and smooth interactions

### 🔧 Technical
- ✅ Laravel 13.4.0 framework
- ✅ Blade templating engine
- ✅ Smarty template integration (bonus)
- ✅ MySQL database support
- ✅ User authentication & authorization
- ✅ CSRF protection
- ✅ Input validation

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Laragon or local development environment

### Installation (5 Minutes)

# Install dependencies
composer install

# Run migrations
php artisan migrate --force

# Seed sample data
php artisan db:seed --class=ProductSeeder

# Start server
php artisan serve
```

Visit: `http://localhost:8000`

### Test Accounts
**Admin:**
- Email: `admin@example.com`
- Password: `Password123!`

**Customer:** Register at `/register`

## 📁 Project Structure

```
yip_test/
├── app/
│   ├── Http/Controllers/
│   │   ├── ProductController       # Product listing & details
│   │   ├── CartController          # Shopping cart
│   │   ├── CheckoutController      # Order processing
│   │   ├── AuthController          # User authentication
│   │   ├── AdminController         # Admin operations
│   │   └── OrderController         # Order management
│   └── Models/
│       ├── Product                 # Product model
│       ├── Category                # Category model
│       ├── Order                   # Order model
│       ├── Cart                    # Shopping cart model
│       └── User                    # User model
├── database/
│   ├── migrations/                 # Database schemas
│   └── seeders/ProductSeeder       # Sample data
├── resources/views/
│   ├── layouts/app.blade.php       # Master layout
│   ├── products/                   # Product pages
│   ├── cart/                       # Cart pages
│   ├── checkout/                   # Checkout pages
│   ├── auth/                       # Auth pages
│   ├── admin/                      # Admin pages
│   ├── orders/                     # Order pages
│   └── smarty/                     # Smarty templates
└── routes/web.php                  # All routes
```

## 🎯 Key Pages & URLs

| Feature | URL | Access |
|---------|-----|--------|
| Home | `/` | Public |
| Products | `/products` | Public |
| Product Details | `/products/{id}` | Public |
| Register | `/register` | Public |
| Login | `/login` | Public |
| Shopping Cart | `/cart` | Authenticated |
| Checkout | `/checkout` | Authenticated |
| My Orders | `/my-orders` | Authenticated |
| Order Details | `/orders/{id}` | Authenticated |
| Admin Dashboard | `/admin/dashboard` | Admin Only |
| Manage Products | `/admin/products` | Admin Only |
| Manage Orders | `/admin/orders` | Admin Only |
