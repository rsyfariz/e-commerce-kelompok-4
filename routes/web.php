<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

/*CUSTOMER ROUTES*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/checkout', function () {
        return view('customer.checkout');
    })->name('checkout');
    
    Route::post('/checkout/process', function () {
        // Logic checkout
    })->name('checkout.process');
    
    Route::get('/transactions', function () {
        return view('customer.transactions');
    })->name('transactions');
    
    Route::get('/transactions/{id}', function ($id) {
        return view('customer.transaction-detail', compact('id'));
    })->name('transactions.show');

    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
});

/*SELLER ROUTES*/
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('seller.dashboard');
    })->name('dashboard');
    
    // Store Registration
    Route::get('/store/register', function () {
        return view('seller.store-register');
    })->name('store.register');
    
    // Store Management
    Route::get('/store', function () {
        return view('seller.store.index');
    })->name('store.index');
    
    Route::get('/store/edit', function () {
        return view('seller.store.edit');
    })->name('store.edit');
    
    // Product Management
    Route::get('/products', function () {
        return view('seller.products.index');
    })->name('products.index');
    
    Route::get('/products/create', function () {
        return view('seller.products.create');
    })->name('products.create');
    
    Route::get('/products/{id}/edit', function ($id) {
        return view('seller.products.edit', compact('id'));
    })->name('products.edit');
    
    // Category Management
    Route::get('/categories', function () {
        return view('seller.categories.index');
    })->name('categories.index');
    
    // Order Management
    Route::get('/orders', function () {
        return view('seller.orders.index');
    })->name('orders.index');
    
    Route::get('/orders/{id}', function ($id) {
        return view('seller.orders.show', compact('id'));
    })->name('orders.show');
    
    // Balance & Withdrawal
    Route::get('/balance', function () {
        return view('seller.balance');
    })->name('balance');
    
    Route::get('/withdrawal', function () {
        return view('seller.withdrawal.index');
    })->name('withdrawal.index');
    
    Route::post('/withdrawal/request', function () {
        // Logic withdrawal
    })->name('withdrawal.request');
});

/*ADMIN ROUTES*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Store Verification
    Route::get('/stores/verify', function () {
        return view('admin.stores.verify');
    })->name('stores.verify');
    
    Route::post('/stores/{id}/approve', function ($id) {
        // Logic approve store
    })->name('stores.approve');
    
    Route::post('/stores/{id}/reject', function ($id) {
        // Logic reject store
    })->name('stores.reject');
    
    // User Management
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
    
    Route::get('/users/{id}', function ($id) {
        return view('admin.users.show', compact('id'));
    })->name('users.show');
    
    // Store Management
    Route::get('/stores', function () {
        return view('admin.stores.index');
    })->name('stores.index');
    
    Route::get('/stores/{id}', function ($id) {
        return view('admin.stores.show', compact('id'));
    })->name('stores.show');
});

/*PROFILE ROUTES*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});