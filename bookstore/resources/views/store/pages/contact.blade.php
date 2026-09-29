{{-- Halaman kontak admin untuk mengirim pesan. --}}
@extends('layouts.store')

@section('title', 'Hubungi Admin')

@section('content')
    <h1 class="h4 mb-3">Hubungi Admin</h1>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">Formulir Pesan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.pages.contact.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="sender_name" class="form-label">Nama Pengirim</label>
                            <input type="text" class="form-control @error('sender_name') is-invalid @enderror"
                                   id="sender_name" name="sender_name"
                                   value="{{ old('sender_name', $user->name) }}" required>
                            @error('sender_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sender_email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control @error('sender_email') is-invalid @enderror"
                                   id="sender_email" name="sender_email"
                                   value="{{ old('sender_email', $user->email) }}" required>
                            @error('sender_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subjek Pesan</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                   id="subject" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Isi Pesan</label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">Informasi Kontak</div>

                <div class="card-body">
                    <p class="mb-2"><i class="bi bi-envelope"></i> admin@bookstore.test</p>
                    <p class="mb-2"><i class="bi bi-telephone"></i> 0811-2244-6688</p>
                </div>
            </div>
        </div>
    </div>
@endsection