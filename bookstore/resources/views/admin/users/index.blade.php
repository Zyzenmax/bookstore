{{-- Daftar pengguna yang sudah mendaftar. --}}
@extends('layouts.admin')

@section('title', 'Daftar Pengguna')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Daftar Pengguna</h1>
        <span class="text-muted small">Total {{ $users->total() }} akun pembeli</span>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2">
                <div class="col-md-5">
                    <label for="search" class="visually-hidden">Kata kunci</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ $keyword }}" placeholder="Cari nama atau email pembeli">
                </div>

                <div class="col-md-3 d-grid d-md-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">Cari</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat Email</th>
                        <th scope="col">Nomor Telepon</th>
                        <th scope="col" class="text-center">Jumlah Pesanan</th>
                        <th scope="col">Terdaftar Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $user->orders_count }}</span>
                            </td>
                            <td>{{ $user->created_at->translatedFormat('d F Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada akun pembeli yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
@endsection