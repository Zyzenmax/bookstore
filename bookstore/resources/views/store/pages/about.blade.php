@extends('layouts.store')

@section('title', 'Tentang Kami')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">

        {{-- Hero Header --}}
        <div class="card border-0 bg-primary text-white rounded-4 shadow-sm mb-4 overflow-hidden position-relative" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
            <div class="card-body p-4 p-md-5 position-relative z-1 text-center text-md-start">
                <div class="row align-items-center">
                    <div class="col-md-7 mb-4 mb-md-0">
                        <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-semibold mb-3">
                            <i class="bi bi-star-fill me-1 text-warning"></i> Tentang BookStore
                        </span>
                        <h1 class="display-6 fw-bold mb-3">Mendekatkan Literasi & Menginspirasi Bangsa</h1>
                        <p class="lead mb-4 text-white-50 fs-6">
                            BookStore hadir sebagai platform toko buku digital yang memberikan kemudahan dalam menemukan, memesan, dan menikmati karya-karya terbaik dari penulis lokal maupun mancanegara.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Visi & Misi --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-3 p-3 mb-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-compass fs-4"></i>
                        </div>
                        <h2 class="h5 fw-bold mb-2">Visi Kami</h2>
                        <p class="text-secondary mb-0 small leading-relaxed">
                            Menjadi destinasi utama pecinta buku yang menyediakan akses literasi berkualitas tinggi, cepat, dan transparan bagi masyarakat luas di seluruh wilayah Indonesia.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-3 p-3 mb-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-shield-check fs-4"></i>
                        </div>
                        <h2 class="h5 fw-bold mb-2">Komitmen & Keunggulan</h2>
                        <p class="text-secondary mb-0 small leading-relaxed">
                            Kami berkomitmen menghadirkan koleksi buku 100% original, pengemasan aman, respons cepat dalam pelayanan pelanggan, serta transaksi aman dan terpercaya.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik / Fact Cards --}}
        <div class="row g-3 mb-4 text-center">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <h3 class="fw-bold text-primary mb-1">1,000+</h3>
                    <p class="text-muted small mb-0">Judul Buku</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <h3 class="fw-bold text-primary mb-1">99%</h3>
                    <p class="text-muted small mb-0">Pelanggan Puas</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <h3 class="fw-bold text-primary mb-1">24/7</h3>
                    <p class="text-muted small mb-0">Akses Pemesanan</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <h3 class="fw-bold text-primary mb-1">100%</h3>
                    <p class="text-muted small mb-0">Original & Aman</p>
                </div>
            </div>
        </div>

        {{-- Keunggulan Fitur / Value Proposition --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4 p-md-5">
                <h2 class="h4 fw-bold text-center mb-4">Mengapa Memilih BookStore?</h2>
                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <h3 class="h6 fw-bold">Pengiriman Cepat</h3>
                        <p class="text-muted small mb-0">Setiap pesanan diproses dengan cermat dan dikemas aman agar buku sampai dengan kondisi prima.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-patch-check fs-4"></i>
                        </div>
                        <h3 class="h6 fw-bold">Jaminan Kualitas</h3>
                        <p class="text-muted small mb-0">Buku dipastikan asli dan berkualitas tinggi dari penerbit terpercaya.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-headset fs-4"></i>
                        </div>
                        <h3 class="h6 fw-bold">Bantuan Ramah</h3>
                        <p class="text-muted small mb-0">Tim customer service siap membantu pertanyaan dan kendala pesanan Anda via menu Hubungi Admin.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Call To Action --}}
        <div class="card border-0 bg-light rounded-4 text-center p-4 p-md-5 shadow-sm">
            <h2 class="h4 fw-bold mb-2">Ada Pertanyaan Lebih Lanjut?</h2>
            <p class="text-muted small mb-4">Jangan ragu untuk menghubungi tim kami jika Anda membutuhkan saran buku atau informasi lainnya.</p>
            <div>
                <a href="{{ route('store.pages.contact') }}" class="btn btn-outline-primary fw-medium px-4 me-2">
                    <i class="bi bi-envelope me-1"></i> Hubungi Admin
                </a>
                <a href="{{ route('store.books.index') }}" class="btn btn-primary fw-medium px-4">
                    <i class="bi bi-bag me-1"></i> Belanja Sekarang
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
