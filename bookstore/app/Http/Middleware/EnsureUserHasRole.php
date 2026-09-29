<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Membatasi akses halaman berdasarkan peran pengguna yang sudah masuk.
 */
class EnsureUserHasRole
{
    /**
     * Menolak permintaan apabila peran pengguna tidak sesuai dengan yang diminta rute.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Pengguna tanpa peran yang sesuai menerima pesan kesalahan 403.
        if ($user === null || $user->role->value !== $role) {
            abort(Response::HTTP_FORBIDDEN, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}
