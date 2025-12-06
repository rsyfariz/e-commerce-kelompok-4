<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
// Ensure SellerOrderController is imported and exists
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\CartController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('home');

/*CUSTOMER ROUTES*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/transactions', function () {
        return view('customer.transactions');
    })->name('transactions');

    Route::get('/transactions/{id}', function ($id) {
        return view('customer.transaction-detail', compact('id'));
    })->name('transactions.show');

    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{transaction}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
});

/*SELLER ROUTES*/
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {

    // Dashboard (Manajemen Pesanan)
    Route::get('/dashboard', [SellerOrderController::class, 'index'])->name('dashboard');

    // Order Management
    Route::controller(SellerOrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::get('/orders/{id}', 'show')->name('orders.show');
        Route::put('/orders/{id}/tracking', 'updateTracking')->name('orders.update-tracking');
        Route::delete('/orders/{id}/tracking', 'removeTracking')->name('orders.remove-tracking');
    });

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
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', function () {
            return view('seller.products.index');
        })->name('index');

        Route::get('/create', function () {
            return view('seller.products.create');
        })->name('create');

        Route::get('/{id}/edit', function ($id) {
            return view('seller.products.edit', compact('id'));
        })->name('edit');
    });

    // Category Management
    Route::get('/categories', function () {
        return view('seller.categories.index');
    })->name('categories.index');

    // Balance & Withdrawal
    Route::get('/balance', function () {
        return view('seller.balance');
    })->name('balance');

    Route::prefix('withdrawal')->name('withdrawal.')->group(function () {
        Route::get('/', function () {
            return view('seller.withdrawal.index');
        })->name('index');

        Route::post('/request', function () {
            // Logic withdrawal
        })->name('request');
    });
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