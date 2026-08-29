<?php

use App\Http\Controllers\Sysadmin\UserController as SysadminUserController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. KHÁCH HÀNG & CỬA HÀNG CHUNG
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Đặt hàng (Checkout)
Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
Route::get('/order-success/{id}', [OrderController::class, 'success'])->name('order.success');

// 2. DASHBOARD ĐIỀU HƯỚNG THEO ROLE & PROFILE CÁ NHÂN
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        return match ($role) {
            'sysadmin' => redirect()->route('sysadmin.users.index'),
            'owner'    => redirect()->route('owner.dashboard'),
            'staff'    => redirect()->route('admin.orders.index'),
            default    => redirect()->route('home'),
        };
    })->name('dashboard');
    Route::get('/my-orders', [OrderController::class, 'history'])->name('order.history');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. SYSADMIN (Quản lý User & Xem Log Đăng nhập)
Route::middleware(['auth', 'role:sysadmin'])->prefix('sysadmin')->name('sysadmin.')->group(function () {
    Route::get('/users', [SysadminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [SysadminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [SysadminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [SysadminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [SysadminUserController::class, 'update'])->name('users.update');
    Route::patch('/users/{id}/toggle-status', [SysadminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::get('/logs', [SysadminUserController::class, 'logs'])->name('logs.index');
});

// 4. CHỦ SHOP (Owner - Thống kê Doanh thu)
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
});

// 5. NHÂN VIÊN & CHỦ SHOP (Staff & Owner - Quản lý Sản phẩm, Danh mục, Đơn hàng)
Route::middleware(['auth', 'role:staff,owner'])->prefix('admin')->name('admin.')->group(function () {
   Route::get('orders/picklist', [AdminOrderController::class, 'pickList'])->name('orders.picklist');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

require __DIR__.'/auth.php';
