<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Mendaftarkan layanan milik aplikasi.
     */
    public function register(): void
    {
        //
    }

    /**
     * Menyiapkan layanan aplikasi sebelum dipakai.
     */
    public function boot(): void
    {
        // Nama bulan dan hari mengikuti bahasa aplikasi (Indonesia).
        Carbon::setLocale(config('app.locale'));

        // Tautan penomoran halaman memakai gaya Bootstrap 5.
        Paginator::useBootstrapFive();

        // Jumlah isi keranjang dipakai pada badge menu navigasi pembeli.
        \Illuminate\Support\Facades\View::composer('partials.store-navbar', function (View $view): void {
            $user = auth()->user();
            $cartQuantity = $user instanceof User ? (int) $user->cartItems()->sum('quantity') : 0;

            $view->with('jumlahKeranjang', $cartQuantity);
        });
    }
}
