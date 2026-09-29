{{-- Halaman checkout untuk melengkapi data pengiriman. --}}
@extends('layouts.store')

@section('title', 'Checkout')

@section('content')
    <h1 class="h4 mb-3">Checkout Pesanan</h1>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">Data Penerima</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.checkout.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                   id="customer_name" name="customer_name"
                                   value="{{ old('customer_name', $user->name) }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror"
                                   id="customer_phone" name="customer_phone"
                                   value="{{ old('customer_phone', $user->phone) }}" required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror"
                                      id="shipping_address" name="shipping_address" rows="3"
                                      required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan (opsional)</label>
                            <textarea class="form-control @error('note') is-invalid @enderror"
                                      id="note" name="note" rows="2">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Buat Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">Ringkasan Pesanan</div>

                <ul class="list-group list-group-flush">
                    @foreach ($cartItems as $cartItem)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold">{{ $cartItem->book->title }}</div>
                                <div class="text-muted small">
                                    {{ $cartItem->quantity }} x
                                    {{ \App\Support\RupiahFormatter::format($cartItem->book->price) }}
                                </div>
                            </div>
                            <span class="fw-semibold">
                                {{ \App\Support\RupiahFormatter::format($cartItem->subtotal()) }}
                            </span>
                        </li>
                    @endforeach

                    <li class="list-group-item d-flex justify-content-between">
                        <span class="fw-semibold">Total Pembayaran</span>
                        <span class="fw-bold text-primary">
                            {{ \App\Support\RupiahFormatter::format($totalPrice) }}
                        </span>
                    </li>
                </ul>

                <div class="card-body">
                    <p class="text-muted small mb-0">
                        Setelah pesanan dibuat, Anda dapat langsung melakukan pembayaran
                        melalui tombol Bayar Sekarang pada halaman rincian pesanan.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection