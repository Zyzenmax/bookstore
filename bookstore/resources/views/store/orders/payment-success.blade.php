{{-- Halaman bukti pembayaran simulasi yang berhasil. --}}
@extends('layouts.store')

@section('title', 'Pembayaran Berhasil')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="display-5 text-success mb-2">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <h1 class="h4 mb-1">Pembayaran Berhasil</h1>
                    <p class="text-muted">
                        Pembayaran simulasi untuk pesanan berikut sudah kami catat.
                    </p>

                    <div class="alert alert-success text-start" role="alert">
                        <p class="mb-1">
                            <strong>Status pembayaran:</strong>
                            <span class="badge bg-success">SUDAH DIBAYAR</span>
                        </p>
                        <p class="mb-0">
                            <strong>Status pesanan:</strong> {{ $order->status->label() }}
                        </p>
                    </div>

                    <dl class="row text-start mb-4">
                        <dt class="col-sm-5">Nomor Pesanan</dt>
                        <dd class="col-sm-7 fw-semibold">{{ $order->order_number }}</dd>

                        <dt class="col-sm-5">Kode Pembayaran</dt>
                        <dd class="col-sm-7">{{ $order->payment?->payment_code ?? '-' }}</dd>

                        <dt class="col-sm-5">Metode Pembayaran</dt>
                        <dd class="col-sm-7">Simulasi (tanpa penyedia pembayaran)</dd>

                        <dt class="col-sm-5">Jumlah Dibayar</dt>
                        <dd class="col-sm-7 fw-semibold text-primary">
                            {{ \App\Support\RupiahFormatter::format($order->total_price) }}
                        </dd>

                        <dt class="col-sm-5">Waktu Pembayaran</dt>
                        <dd class="col-sm-7">
                            {{ $order->paid_at?->translatedFormat('d F Y, H:i') }} WIB
                        </dd>
                    </dl>

                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('store.orders.show', $order) }}" class="btn btn-primary">
                            Lihat Rincian Pesanan
                        </a>
                        <a href="{{ route('store.books.index') }}" class="btn btn-outline-secondary">
                            Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection