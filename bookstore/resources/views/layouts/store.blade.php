{{-- Kerangka halaman untuk admin dan pembeli. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Katalog Buku') - BookStore</title>

    {{-- Berkas Bootstrap dan ikon dimuat dari folder public agar tidak bergantung pada internet. --}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    @include('partials.store-navbar')

    <main class="container py-4 flex-grow-1">
        @include('partials.alerts')

        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>
</html>