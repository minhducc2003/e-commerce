<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductUserController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\OrderUserController;
use App\Http\Middleware\CheckRole;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword']);

// User Routes
Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment'); // Show Payment Form
Route::post('/payment', [PaymentController::class, 'completePayment'])->name('payment.complete'); // Complete Payment
Route::get('/', [ProductUserController::class, 'index'])->name('user.index');
Route::get('/product/{id}', [ProductUserController::class, 'viewProduct'])->name('user.product');
Route::get('/cart', [CartController::class, 'viewCart'])->name('user.cart'); 
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add'); 
Route::put('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update'); 
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove'); 

// Routes for logged-in users with role 'user'
Route::prefix('user')->middleware(['auth', 'checkRole:user'])->group(function () {
    Route::post('/order', [OrderUserController::class, 'placeOrder'])->name('order.place');
    Route::get('/orders', [OrderUserController::class, 'index'])->name('user.orders'); 
    Route::get('/orders/{id}', [OrderUserController::class, 'viewOrder'])->name('user.order'); 
});

// Admin Routes

Route::prefix('admin')->middleware([CheckRole::class . ':admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Các route khác dành cho admin...
    // Order management routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderAdminController::class, 'index'])->name('admin.orders.index'); 
        Route::put('{id}/approve', [OrderAdminController::class, 'approve'])->name('admin.orders.approve'); 
        Route::put('{id}/deliver', [OrderAdminController::class, 'deliver'])->name('admin.orders.deliver'); 
    });

    // User management routes
    Route::prefix('accounts')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('admin.accounts.index');
        Route::get('/create', [AccountController::class, 'create'])->name('admin.accounts.create');
        Route::post('/', [AccountController::class, 'store'])->name('admin.accounts.store');
        Route::get('{id}/edit', [AccountController::class, 'edit'])->name('admin.accounts.edit');
        Route::put('{id}', [AccountController::class, 'update'])->name('admin.accounts.update');
        Route::delete('{id}', [AccountController::class, 'destroy'])->name('admin.accounts.destroy');
    });

    // Product management routes
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'indexProducts'])->name('admin.products.index'); // List products
        Route::get('/create', [ProductController::class, 'createProduct'])->name('admin.products.create'); // Create product form
        Route::post('/', [ProductController::class, 'storeProduct'])->name('admin.products.store'); // Store product
        Route::get('{id}/edit', [ProductController::class, 'editProduct'])->name('admin.products.edit'); // Edit product form
        Route::put('{id}', [ProductController::class, 'updateProduct'])->name('admin.products.update'); // Update product
        Route::delete('{id}', [ProductController::class, 'destroyProduct'])->name('admin.products.destroy'); // Delete product
    });

    // Category management routes
    Route::prefix('categories')->group(function () {
        Route::get('/', [ProductController::class, 'indexCategories'])->name('admin.categories.index'); // List categories
        Route::get('/create', [ProductController::class, 'createCategory'])->name('admin.categories.create'); // Create category form
        Route::post('/', [ProductController::class, 'storeCategory'])->name('admin.categories.store'); // Store category
        Route::get('{id}/edit', [ProductController::class, 'editCategory'])->name('admin.categories.edit'); // Edit category form
        Route::put('{id}', [ProductController::class, 'updateCategory'])->name('admin.categories.update'); // Update category
        Route::delete('{id}', [ProductController::class, 'destroyCategory'])->name('admin.categories.destroy'); // Delete category
    });
    
    // Order management routes
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index'); // List orders
    Route::put('/orders/{id}/approve', [OrderController::class, 'approve'])->name('admin.orders.approve'); // Approve order
    Route::put('/orders/{id}/deliver', [OrderController::class, 'deliver'])->name('admin.orders.deliver'); // Mark order as delivered
    Route::get('/orders/{id}', [OrderController::class, 'viewOrder'])->name('admin.orders.view'); // View order details




});
