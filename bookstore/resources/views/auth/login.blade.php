{{-- Halaman login bersama untuk admin dan pembeli. --}}
@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 mb-1">Masuk ke Akun</h2>
            <p class="text-muted small">Satu halaman ini dipakai oleh admin dan pembeli.</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>

            <hr>

            <div class="text-center small">
                <a href="{{ route('register') }}">Daftar sebagai pembeli</a>
            </div>
        </div>
    </div>

    <div class="card mt-3 shadow-sm">
        <div class="card-body small">
            <p class="fw-semibold mb-1">Akun contoh untuk pengujian:</p>
            <p class="mb-1">Admin: admin@bookstore.test / password</p>
            <p class="mb-0">Pembeli: pembeli@bookstore.test / password</p>
        </div>
    </div>
@endsection
