<footer class="bg-dark text-white pt-5 pb-4 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <h2 class="h4 fw-bold">NusaCendana</h2>
                <p class="text-white-50 mb-0">
                    Toko Buku Nusa Cendana adalah pusat buku Original kedokteran dan buku pelajaran bahasa Jerman (Netzwerk neu A1, A2, dan B1)
                </p>
            </div>

            <div class="col-6 col-lg-2">
                <h3 class="h6 fw-bold">Menu</h3>
                <ul class="list-unstyled mb-0">
                    <li><a href="{{ route('home') }}" class="footer-link">Beranda</a></li>
                    <li><a href="{{ route('books.index') }}" class="footer-link">Katalog</a></li>
                    <li><a href="{{ route('about') }}" class="footer-link">Tentang</a></li>
                    <li><a href="{{ route('contact') }}" class="footer-link">Kontak</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h3 class="h6 fw-bold">Akun</h3>
                <ul class="list-unstyled mb-0">
                    @guest
                        <li><a href="{{ route('login') }}" class="footer-link">Login</a></li>
                        <li><a href="{{ route('register') }}" class="footer-link">Daftar</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}" class="footer-link">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="footer-link">Profil</a></li>
                    @endguest
                </ul>
            </div>

            <div class="col-lg-3">
                <h3 class="h6 fw-bold">Kontak</h3>
                <div class="text-white-50 small">
                    <div>Email: tbnusacendana@gmail.com <br> tbnusacendana@yahoo.com</div>
                    <div>Telepon: (022) 4231544</div>
                    <div>Alamat: Jl. Braga No.115, Braga, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40111</div>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 text-white-50 small">
            <div>&copy; {{ now()->year }} NusaCendana. All rights reserved.</div>
            <div>Sistem Informasi Toko Buku Online.</div>
        </div>
    </div>
</footer>
