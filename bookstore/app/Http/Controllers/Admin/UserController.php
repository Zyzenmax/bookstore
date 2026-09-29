<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Menampilkan daftar pengguna yang sudah mendaftar.
 */
class UserController extends Controller
{
    /**
     * Menampilkan daftar akun pembeli beserta jumlah pesanannya.
     */
    public function index(Request $request): View
    {
        $keyword = trim($request->string('search')->value());

        $users = User::query()
            // Hanya akun pembeli yang ditampilkan pada daftar ini.
            ->where('role', UserRole::User)
            ->when($keyword !== '', fn ($query) => $query->where(function ($query) use ($keyword): void {
                $query->where('name', 'like', '%'.$keyword.'%')
                    ->orWhere('email', 'like', '%'.$keyword.'%');
            }))
            ->withCount('orders')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'keyword'));
    }
}
