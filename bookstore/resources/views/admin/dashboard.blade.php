{{-- Dasbor admin berisi ringkasan data toko. --}}
@extends('layouts.admin')

@section('title', 'Dasbor Admin')

@section('content')
    <h1 class="h4 mb-3">Dasbor Admin</h1>

    {{-- Kartu statistik utama. --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card statistic-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Judul Buku</p>
                    <p class="h4 mb-0">{{ $statistics['total_books'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card statistic-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Kategori</p>
                    <p class="h4 mb-0">{{ $statistics['total_categories'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card statistic-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Akun Pembeli</p>
                    <p class="h4 mb-0">{{ $statistics['total_customers'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card statistic-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Total Pesanan</p>
                    <p class="h4 mb-0">{{ $statistics['total_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card statistic-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Pesanan Belum Dibayar</p>
                    <p class="h4 mb-0">{{ $statistics['unpaid_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card statistic-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Pesan Belum Dibaca</p>
                    <p class="h4 mb-0">{{ $statistics['unread_messages'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-6">
            <div class="card statistic-card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted small mb-1">Pendapatan dari Pesanan Lunas</p>
                    <p class="h4 mb-0">
                        {{ \App\Support\RupiahFormatter::format($statistics['total_revenue']) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <span class="fw-semibold">Pesanan Terbaru</span>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">
                Lihat Semua Pesanan
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nomor Pesanan</th>
                        <th scope="col">Pembeli</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" class="text-end">Total</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestOrders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->order_number }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->translatedFormat('d F Y, H:i') }}</td>
                            <td class="text-end">
                                {{ \App\Support\RupiahFormatter::format($order->total_price) }}
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $order->status->badgeClass() }}">
                                    {{ $order->status->label() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="btn btn-sm btn-outline-primary">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada pesanan yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection