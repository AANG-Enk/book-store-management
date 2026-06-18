<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Customer Dashboard - BookStore')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    @include('partials.customer.navbar')

    <main id="main-content" tabindex="-1" class="py-4">
        <div class="container">
            @include('partials.flash')

            @yield('content')
        </div>
    </main>

    @include('partials.public.footer')

    @stack('scripts')
</body>
</html>
