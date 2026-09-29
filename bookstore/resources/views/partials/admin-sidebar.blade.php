<div class="offcanvas-lg offcanvas-start bg-dark text-white admin-sidebar border-end" tabindex="-1" id="adminSidebar" aria-labelledby="adminSidebarLabel">
    <div class="offcanvas-header border-bottom border-secondary px-3 py-3">
        <h5 class="offcanvas-title text-white fw-bold d-flex align-items-center gap-2" id="adminSidebarLabel">
            <i class="bi bi-speedometer2 text-primary fs-4"></i> BookStore Admin
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#adminSidebar" aria-label="Tutup"></button>
    </div>

    <div class="sidebar-brand d-none d-lg-flex align-items-center gap-2 p-3 border-bottom border-secondary text-decoration-none text-white fs-5 fw-bold">
        <i class="bi bi-speedometer2 text-primary fs-4"></i>
        <span>BookStore Admin</span>
    </div>

    <div class="offcanvas-body p-0 d-flex flex-column justify-content-between h-100">
        <ul class="nav nav-pills flex-column p-3 gap-1 sidebar-nav w-100">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dasbor
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags me-2"></i>
                    Kategori
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.books.index') }}" class="nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                    <i class="bi bi-book me-2"></i>
                    Buku
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i>
                    Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-cart-check me-2"></i>
                    Pesanan
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="bi bi-envelope me-2"></i>
                    Pesan
                </a>
            </li>
        </ul>
        <div class="p-3 mt-0 offcanvas-lg offcanvas-start bg-dark text-white admin-sidebar border-end">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</div>
