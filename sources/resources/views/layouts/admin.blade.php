<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - BookStore')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    <div class="admin-shell">
        @include('partials.admin.sidebar')

        <div class="admin-main">
            @include('partials.admin.navbar')

            <main id="main-content" tabindex="-1" class="container-fluid py-4">
                @include('partials.flash')

                @yield('content')
            </main>
        </div>
    </div>

    @include('partials.labkerkomit-watermark')

    @stack('scripts')
</body>
</html>
