<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BookStore - Toko Buku Online')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    @include('partials.public.navbar')

    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    @include('partials.public.footer')

    @stack('scripts')
</body>
</html>
