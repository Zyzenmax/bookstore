<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Store\BookController as StoreBookController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\OrderController as StoreOrderController;
use App\Http\Controllers\Store\PageController;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Awal & Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('store.books.index');
});

Route::get('/dashboard', function (Request $request) {
    if ($request->user() && $request->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('store.books.index');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profil User (Breeze)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Area Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:'.UserRole::Admin->value])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::resource('books', AdminBookController::class)->except('show');

        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');

        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

        Route::get('messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
    });

/*
|--------------------------------------------------------------------------
| Area Pembeli (Toko)
|--------------------------------------------------------------------------
*/

Route::name('store.')->group(function (): void {
    // Rute Publik (Bisa diakses tanpa login)
    Route::get('/tentang-kami', [PageController::class, 'about'])->name('pages.about');
    Route::get('/katalog', [HomeController::class, 'index'])->name('books.index');
    Route::get('/katalog/{book}', [StoreBookController::class, 'show'])->name('books.show');

    // Rute Khusus Pembeli/User
    Route::middleware(['auth', 'role:'.UserRole::User->value])->group(function (): void {
        // Keranjang belanja.
        Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
        Route::post('/keranjang/{book}', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/keranjang/{cartItem}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/keranjang/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

        // Checkout dan pesanan.
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

        Route::get('/pesanan', [StoreOrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{order}/pembayaran-berhasil', [StoreOrderController::class, 'paymentSuccess'])->name('orders.payment-success');
        Route::post('/pesanan/{order}/bayar', [StoreOrderController::class, 'pay'])->name('orders.pay');
        Route::get('/pesanan/{order}', [StoreOrderController::class, 'show'])->name('orders.show');

        // Halaman kontak admin.
        Route::get('/hubungi-admin', [PageController::class, 'contact'])->name('pages.contact');
        Route::post('/hubungi-admin', [PageController::class, 'sendMessage'])->name('pages.contact.store');
    });
});

require __DIR__.'/auth.php';
