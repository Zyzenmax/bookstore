<nav class="navbar navbar-expand-lg navbar-dark store-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('store.books.index') }}">
            <i class="bi bi-book-half fs-3"></i>
            <span>BookStore</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="collapse" data-bs-target="#menuPembeli" aria-controls="menuPembeli" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mt-2 mt-lg-0" id="menuPembeli">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('store.books.*') ? 'active' : '' }}" href="{{ route('store.books.index') }}">
                        <i class="bi bi-shop fs-6"></i> Katalog Buku
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('store.pages.about') ? 'active' : '' }}" href="{{ route('store.pages.about') }}">
                        <i class="bi bi-info-circle fs-6"></i> Tentang Kami
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('store.orders.*') ? 'active' : '' }}" href="{{ route('store.orders.index') }}">
                        <i class="bi bi-bag-check fs-6"></i> Pesanan Saya
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('store.pages.contact') ? 'active' : '' }}" href="{{ route('store.pages.contact') }}">
                        <i class="bi bi-headset fs-6"></i> Hubungi Admin
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav mb-2 mb-lg-0 align-items-lg-center gap-2">
                <li class="nav-item me-lg-1">
                    <a class="nav-link cart-btn d-flex align-items-center gap-2 px-3 {{ request()->routeIs('store.cart.*') ? 'active' : '' }}" href="{{ route('store.cart.index') }}">
                        <i class="bi bi-cart3 fs-5 text-warning"></i>
                        <span>Keranjang</span>
                        <span class="badge bg-warning text-dark rounded-pill px-2 py-1">{{ $jumlahKeranjang }}</span>
                    </a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="fw-medium">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            @if(auth()->user()->isAdmin())
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i> Dasbor Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-right"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 px-3" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right fs-5"></i> Masuk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-warning fw-semibold px-3 text-dark rounded-pill ms-lg-1" href="{{ route('register') }}">
                            Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>