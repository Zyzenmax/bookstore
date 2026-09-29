{{-- Kaki halaman yang dipakai pada seluruh halaman aplikasi. --}}

<footer class="bg-white border-top py-3 mt-4">
    <div class="container text-center text-muted small">
        <div class="d-flex justify-content-center gap-3 mb-2">
            <a href="{{ route('store.books.index') }}" class="text-decoration-none text-muted">Katalog</a>
            <span>&bull;</span>
            <a href="{{ route('store.pages.about') }}" class="text-decoration-none text-muted">Tentang Kami</a>
            <span>&bull;</span>
            <a href="{{ route('store.pages.contact') }}" class="text-decoration-none text-muted">Hubungi Admin</a>
        </div>
        <p class="mb-0">&copy; {{ date('Y') }} BookStore. All rights reserved.</p>
    </div>
</footer>