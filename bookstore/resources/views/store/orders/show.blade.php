{{-- Halaman rincian pesanan dan pembayaran simulasi. --}}
@extends('layouts.store')

@section('title', 'Pesanan ' . $order->order_number)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Pesanan {{ $order->order_number }}</h1>
        <span class="badge {{ $order->status->badgeClass() }} fs-6">{{ $order->status->label() }}</span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Daftar Buku yang Dipesan</div>

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
                                <th colspan="3" class="text-end">Total Pembayaran</th>
                                <th class="text-end">
                                    {{ \App\Support\RupiahFormatter::format($order->total_price) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if ($order->isPaid() && $order->payment !== null)
                {{-- Bukti pembayaran simulasi yang sudah berhasil. --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-semibold">Bukti Pembayaran</div>
                    <div class="card-body">
                        <div class="alert alert-success mb-3">
                            Pembayaran berhasil diproses pada
                            {{ $order->payment->paid_at->translatedFormat('d F Y, H:i') }} WIB.
                        </div>

                        <dl class="row mb-0">
                            <dt class="col-sm-4">Kode Pembayaran</dt>
                            <dd class="col-sm-8">{{ $order->payment->payment_code }}</dd>

                            <dt class="col-sm-4">Metode</dt>
                            <dd class="col-sm-8">Pembayaran simulasi</dd>

                            <dt class="col-sm-4">Jumlah Dibayar</dt>
                            <dd class="col-sm-8">
                                {{ \App\Support\RupiahFormatter::format($order->payment->amount) }}
                            </dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-success">Berhasil</span>
                            </dd>
                        </dl>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-semibold">Data Pengiriman</div>
                <div class="card-body">
                    <p class="mb-1 fw-semibold">{{ $order->customer_name }}</p>
                    <p class="mb-1 text-muted small">{{ $order->customer_phone }}</p>
                    <p class="text-muted small">{{ $order->shipping_address }}</p>

                    @if ($order->note)
                        <p class="mb-0 small"><strong>Catatan:</strong> {{ $order->note }}</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">Pembayaran</div>
                <div class="card-body">
                    @if ($order->isPaid())
                        <p class="mb-3 text-success">
                            <i class="bi bi-check-circle"></i> Pesanan ini sudah dibayar.
                        </p>
                        <a href="{{ route('store.orders.payment-success', $order) }}"
                           class="btn btn-outline-success w-100">Lihat Bukti Pembayaran</a>
                    @else
                        <p class="text-muted small">
                            Pembayaran dilakukan melalui simulasi. Tekan tombol di bawah ini
                            untuk menandai pesanan sebagai sudah dibayar.
                        </p>

                        {{-- Tombol pembayaran memunculkan modal konfirmasi. --}}
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal"
                                data-bs-target="#modalPembayaran">
                            <i class="bi bi-credit-card"></i> Bayar Sekarang
                        </button>

                        <div class="modal fade" id="modalPembayaran" tabindex="-1"
                             aria-labelledby="judulModalPembayaran" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title h5" id="judulModalPembayaran">
                                            Konfirmasi Pembayaran
                                        </h2>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-2">
                                            Anda akan membayar pesanan
                                            <strong>{{ $order->order_number }}</strong> sebesar
                                            <strong>{{ \App\Support\RupiahFormatter::format($order->total_price) }}</strong>.
                                        </p>
                                        <p class="text-muted small mb-0">
                                            Pembayaran ini hanya simulasi sehingga tidak ada uang yang
                                            benar-benar dipotong.
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Batal</button>

                                        {{-- Formulir pembayaran dikirim setelah pengguna menekan tombol konfirmasi. --}}
                                        <form method="POST" action="{{ route('store.orders.pay', $order) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                Ya, Bayar Sekarang
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('store.orders.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                        Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection