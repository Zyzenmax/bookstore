{{-- Halaman pendaftaran khusus untuk akun pembeli. --}}
@extends('layouts.auth')

@section('title', 'Daftar Akun')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 mb-1">Daftar Akun Pembeli</h2>
            <p class="text-muted small">Lengkapi data di bawah ini untuk membuat akun baru.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Nomor Telepon (Opsional)</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                           id="phone" name="phone" value="{{ old('phone') }}">
                    @error('phone')
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

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" class="form-control"
                           id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
            </form>

            <hr>

            <p class="text-center mb-0 small">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </p>
        </div>
    </div>
@endsection
