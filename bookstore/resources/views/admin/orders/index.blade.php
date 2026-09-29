{{-- Daftar pesanan dari seluruh pengguna. --}}
@extends('layouts.admin')

@section('title', 'Data Pesanan')

@section('content')
    <h1 class="h4 mb-3">Data Pesanan</h1>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2">
                <div class="col-md-4">
                    <label for="status" class="visually-hidden">Status pesanan</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua status</option>
                        @foreach (\App\OrderStatus::cases() as $statusOption)
                            <option value="{{ $statusOption->value }}" @selected($status === $statusOption->value)>
                                {{ $statusOption->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-grid d-md-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">Saring</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary flex-fill">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-admin mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nomor Pesanan</th>
                        <th scope="col">Pembeli</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" class="text-center">Jumlah Buku</th>
                        <th scope="col" class="text-end">Total</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="fw-semibold">{{ $order->order_number }}</td>
                            <td>
                                <div>{{ $order->user->name }}</div>
                                <div class="text-muted small">{{ $order->user->email }}</div>
                            </td>
                            <td>{{ $order->created_at->translatedFormat('d F Y, H:i') }}</td>
                            <td class="text-center">{{ $order->items_count }}</td>
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
                            <td colspan="7" class="text-center text-muted">Belum ada pesanan yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>
@endsection