{{-- Kerangka halaman khusus admin. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dasbor Admin') - BookStore</title>

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-light">
    <div class="d-flex min-vh-100">
        {{-- Sidebar partial --}}
        @include('partials.admin-sidebar')

        {{-- Area Konten Utama --}}
        <div class="flex-grow-1 d-flex flex-column min-w-0">
            {{-- Header Topbar (Tombol menu mobile & info pengguna) --}}
            <header class="navbar navbar-expand bg-white border-bottom shadow-sm px-3 py-2 sticky-top">
                <div class="container-fluid px-0">
                    <button class="btn btn-outline-secondary d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebar" aria-controls="adminSidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <span class="navbar-brand mb-0 h1 fs-5 fw-semibold text-secondary d-none d-sm-inline-block">
                        @yield('title', 'Dasbor Admin')
                    </span>
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark fw-medium d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 text-primary"></i>
                                <span>{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                            <i class="bi bi-box-arrow-right"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="container-fluid p-4 flex-grow-1">
                @include('partials.alerts')

                @yield('content')
            </main>
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>
</html>