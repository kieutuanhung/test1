<?php
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\PasswordExpiredController;
use Illuminate\Support\Facades\Route;

// Trang chủ cửa hàng & Xem sản phẩm
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Route Giỏ hàng (Cart)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
// route cho trang "Mật khẩu hết hạn")
Route::middleware('auth')->group(function () {
    Route::get('/password-expired', [PasswordExpiredController::class, 'show'])->name('password.expired');
    Route::put('/password-expired', [PasswordExpiredController::class, 'update'])->name('password.expired.update');
});

// Route Đặt hàng (Checkout) 
Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');
Route::get('/order-success/{id}', [OrderController::class, 'success'])->name('order.success');
// Route User thông thường
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'password.expiry' ])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');       // 👈 MỚI
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');       // 👈 MỚI
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success'); // 👈 MỚI
});

// Route Admin (Bảo vệ bởi Middleware 'auth' và 'admin')
Route::middleware(['auth' , 'verified', 'password.expiry' , 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return 'Trang quản trị Hệ thống (Admin Dashboard)!';
    })->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
   // Route Đơn hàng cho Admin
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

require __DIR__.'/auth.php';

