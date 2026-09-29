{{-- Rincian satu pesanan beserta data pembayarannya. --}}
@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Pesanan {{ $order->order_number }}</h1>
        <div>
            <span class="badge {{ $order->status->badgeClass() }} fs-6">{{ $order->status->label() }}</span>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm ms-2">Kembali</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">Buku yang Dipesan</div>

                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Judul Buku</th>
                                <th scope="col" class="text-end">Harga</th>
                                <th scope="col" class="text-center">Jumlah</th>
                                <th scope="col" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->book_title }}</td>
                                    <td class="text-end">
                                        {{ \App\Support\RupiahFormatter::format($item->price) }}
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">
                                        {{ \App\Support\RupiahFormatter::format($item->subtotal) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th class="text-end">
                                    {{ \App\Support\RupiahFormatter::format($order->total_price) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Data Pembeli</div>
                <div class="card-body">
                    <p class="mb-1 fw-semibold">{{ $order->user->name }}</p>
                    <p class="mb-1 text-muted small">{{ $order->user->email }}</p>
                    <p class="mb-0 text-muted small">
                        Bergabung {{ $order->user->created_at->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Data Pengiriman</div>
                <div class="card-body">
                    <p class="mb-1 fw-semibold">{{ $order->customer_name }}</p>
                    <p class="mb-1 text-muted small">{{ $order->customer_phone }}</p>
                    <p class="mb-2 text-muted small">{{ $order->shipping_address }}</p>

                    @if ($order->note)
                        <p class="mb-0 small"><strong>Catatan pembeli:</strong> {{ $order->note }}</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">Data Pembayaran</div>
                <div class="card-body">
                    @if ($order->payment !== null)
                        <dl class="row mb-0 small">
                            <dt class="col-5">Kode</dt>
                            <dd class="col-7">{{ $order->payment->payment_code }}</dd>

                            <dt class="col-5">Metode</dt>
                            <dd class="col-7">Simulasi</dd>

                            <dt class="col-5">Jumlah</dt>
                            <dd class="col-7">
                                {{ \App\Support\RupiahFormatter::format($order->payment->amount) }}
                            </dd>

                            <dt class="col-5">Waktu</dt>
                            <dd class="col-7">
                                {{ $order->payment->paid_at->translatedFormat('d F Y, H:i') }} WIB
                            </dd>
                        </dl>
                    @else
                        <p class="mb-0 text-muted small">
                            Pesanan ini belum dibayar oleh pembeli.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection