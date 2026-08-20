@extends('layouts.customer')

@section('title', 'Checkout - Toko Buku NusaCendana')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Checkout</h1>
        <p class="text-secondary mb-0">
            Lengkapi data pengiriman. Ongkos kirim dihitung otomatis secara akurat via RajaOngkir.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <div class="fw-semibold mb-1">Terjadi kesalahan pada data formulir:</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="checkout-form" method="POST" action="{{ route('customer.checkout.store') }}">
        @csrf

        <!-- Hidden inputs for calculated shipping details -->
        <input type="hidden" name="shipping_province" id="input_shipping_province" value="{{ old('shipping_province') }}">
        <input type="hidden" name="shipping_city" id="input_shipping_city" value="{{ old('shipping_city') }}">
        <input type="hidden" name="shipping_courier" id="input_shipping_courier" value="{{ old('shipping_courier') }}">
        <input type="hidden" name="shipping_service" id="input_shipping_service" value="{{ old('shipping_service') }}">
        <input type="hidden" name="shipping_cost" id="input_shipping_cost" value="{{ old('shipping_cost', 0) }}">
        <input type="hidden" name="shipping_weight" id="input_shipping_weight" value="{{ $totalWeight }}">

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- 1. Data Customer -->
                <div class="card content-card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge bg-primary-subtle text-primary rounded-circle p-2 px-3 fw-bold">1</span>
                            <h2 class="h5 fw-bold mb-0">Data Penerima</h2>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                                <input
                                    id="customer_name"
                                    type="text"
                                    name="customer_name"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    value="{{ old('customer_name', auth()->user()->name) }}"
                                    required
                                    maxlength="150"
                                >
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input
                                    id="customer_email"
                                    type="email"
                                    name="customer_email"
                                    class="form-control @error('customer_email') is-invalid @enderror"
                                    value="{{ old('customer_email', auth()->user()->email) }}"
                                    required
                                    maxlength="150"
                                >
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="customer_phone" class="form-label">No. Telepon / WhatsApp <span class="text-danger">*</span></label>
                                <input
                                    id="customer_phone"
                                    type="text"
                                    name="customer_phone"
                                    class="form-control @error('customer_phone') is-invalid @enderror"
                                    value="{{ old('customer_phone') }}"
                                    required
                                    maxlength="30"
                                    placeholder="Contoh: 081234567890"
                                >
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Alamat & Pengiriman RajaOngkir -->
                <div class="card content-card mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary-subtle text-primary rounded-circle p-2 px-3 fw-bold">2</span>
                                <h2 class="h5 fw-bold mb-0">Alamat & Pengiriman (RajaOngkir)</h2>
                            </div>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                <i class="bi bi-truck me-1"></i> Auto-Calculated
                            </span>
                        </div>

                        <div class="row g-3">
                            <!-- Provinsi -->
                            <div class="col-md-6">
                                <label for="select_province" class="form-label">Provinsi Tujuan <span class="text-danger">*</span></label>
                                <select id="select_province" class="form-select @error('shipping_province') is-invalid @enderror" required>
                                    <option value="">-- Memuat provinsi... --</option>
                                </select>
                                @error('shipping_province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kota / Kabupaten -->
                            <div class="col-md-6">
                                <label for="select_city" class="form-label">Kota / Kabupaten Tujuan <span class="text-danger">*</span></label>
                                <select id="select_city" class="form-select @error('shipping_city') is-invalid @enderror" disabled required>
                                    <option value="">-- Pilih provinsi terlebih dahulu --</option>
                                </select>
                                @error('shipping_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kurir -->
                            <div class="col-md-6">
                                <label for="select_courier" class="form-label">Pilihan Kurir Ekspedisi <span class="text-danger">*</span></label>
                                <select id="select_courier" class="form-select @error('shipping_courier') is-invalid @enderror" disabled required>
                                    <option value="">-- Pilih kurir --</option>
                                    <option value="jne" @selected(old('shipping_courier') === 'jne' || old('shipping_courier') === 'JNE')>JNE (Jalur Nugraha Ekakurir)</option>
                                    <option value="pos" @selected(old('shipping_courier') === 'pos' || old('shipping_courier') === 'POS')>POS Indonesia</option>
                                    <option value="tiki" @selected(old('shipping_courier') === 'tiki' || old('shipping_courier') === 'TIKI')>TIKI (Titipan Kilat)</option>
                                </select>
                                @error('shipping_courier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kode Pos -->
                            <div class="col-md-6">
                                <label for="shipping_postal_code" class="form-label">Kode Pos</label>
                                <input
                                    id="shipping_postal_code"
                                    type="text"
                                    name="shipping_postal_code"
                                    class="form-control @error('shipping_postal_code') is-invalid @enderror"
                                    value="{{ old('shipping_postal_code') }}"
                                    maxlength="20"
                                    placeholder="Contoh: 85111"
                                >
                                @error('shipping_postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pilihan Layanan & Tarif Ongkir (Dynamic Radio Options) -->
                            <div class="col-12 mt-3">
                                <label class="form-label d-flex justify-content-between align-items-center">
                                    <span>Pilih Layanan & Tarif Ongkos Kirim <span class="text-danger">*</span></span>
                                    <span id="shipping-loading-spinner" class="spinner-border spinner-border-sm text-primary d-none" role="status"></span>
                                </label>

                                <div id="services-container" class="border rounded p-3 bg-light-subtle">
                                    <div id="services-placeholder" class="text-secondary small text-center py-3">
                                        <i class="bi bi-geo-alt fs-4 d-block mb-1 text-muted"></i>
                                        Pilih provinsi, kota, dan kurir di atas untuk menghitung ongkir secara otomatis.
                                    </div>
                                    <div id="services-list" class="vstack gap-2 d-none">
                                        <!-- Dynamic radio list will be rendered here -->
                                    </div>
                                </div>
                                @error('shipping_service')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="col-12">
                                <label for="shipping_address" class="form-label">Alamat Lengkap Pengiriman <span class="text-danger">*</span></label>
                                <textarea
                                    id="shipping_address"
                                    name="shipping_address"
                                    rows="3"
                                    class="form-control @error('shipping_address') is-invalid @enderror"
                                    required
                                    maxlength="1000"
                                    placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan/desa, kecamatan, patokan gedung/rumah"
                                >{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Catatan -->
                            <div class="col-12">
                                <label for="notes" class="form-label">Catatan Tambahan</label>
                                <textarea
                                    id="notes"
                                    name="notes"
                                    rows="2"
                                    class="form-control @error('notes') is-invalid @enderror"
                                    maxlength="1000"
                                    placeholder="Opsional, contoh: tolong packing ekstra bubble wrap, kirim saat jam kerja"
                                >{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Item Pesanan -->
                <div class="card content-card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary-subtle text-primary rounded-circle p-2 px-3 fw-bold">3</span>
                                <h2 class="h5 fw-bold mb-0">Item Pesanan</h2>
                            </div>
                            <span class="badge bg-secondary-subtle text-secondary">
                                Total Berat: {{ $formattedWeight }}
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Buku</th>
                                        <th>Berat / Item</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $cartItem)
                                        <tr>
                                            <td>
                                                <div class="fw-semibold">{{ $cartItem->book->title }}</div>
                                                <div class="small text-secondary">
                                                    {{ $cartItem->book->category?->name ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="small text-secondary">{{ $cartItem->book->formatted_weight }}</td>
                                            <td>{{ $cartItem->book->formatted_price }}</td>
                                            <td>{{ $cartItem->quantity }}</td>
                                            <td class="text-end fw-semibold">
                                                {{ $cartItem->formatted_subtotal }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-pencil-square me-1"></i> Edit Keranjang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar Ringkasan Checkout -->
            <div class="col-lg-4">
                <div class="card content-card sticky-lg-top cart-summary-card border-0 shadow-sm" style="top: 2rem;">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Ringkasan Pembayaran</h2>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Total Item</span>
                            <span class="fw-semibold">{{ $cartItems->sum('quantity') }} pcs</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Total Berat</span>
                            <span class="fw-semibold text-dark">{{ $formattedWeight }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Subtotal Buku</span>
                            <span class="fw-semibold">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary">Ongkos Kirim</span>
                            <span id="summary-shipping-cost" class="fw-semibold text-warning">
                                {{ old('shipping_cost') ? 'Rp ' . number_format((float) old('shipping_cost'), 0, ',', '.') : 'Pilih layanan kurir' }}
                            </span>
                        </div>

                        <div id="selected-service-badge" class="alert alert-info py-2 px-3 small mb-3 {{ old('shipping_service') ? '' : 'd-none' }}">
                            <div class="fw-bold" id="badge-courier-service">{{ old('shipping_courier') }} - {{ old('shipping_service') }}</div>
                            <div class="text-muted" id="badge-courier-etd">Estimasi pengiriman otomatis</div>
                        </div>

                        <div class="p-3 bg-light rounded mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-secondary">Total Tagihan</span>
                                <span id="summary-total-price" class="h4 fw-bold text-primary mb-0">
                                    Rp {{ number_format($cartTotal + (float) old('shipping_cost', 0), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button id="btn-submit-order" type="submit" class="btn btn-primary btn-lg w-100 shadow-sm" disabled>
                            <i class="bi bi-shield-check me-1"></i> Buat Pesanan
                        </button>

                        <div class="small text-muted mt-3 text-center">
                            <i class="bi bi-info-circle me-1"></i>
                            Setelah pesanan dibuat, Anda akan langsung diarahkan ke pembayaran.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cartTotal = {{ (float) $cartTotal }};
    const routes = {
        provinces: "{{ route('customer.shipping.provinces') }}",
        cities: "{{ route('customer.shipping.cities') }}",
        calculateCost: "{{ route('customer.shipping.calculate-cost') }}"
    };
    const csrfToken = "{{ csrf_token() }}";

    // Form elements
    const selectProvince = document.getElementById('select_province');
    const selectCity = document.getElementById('select_city');
    const selectCourier = document.getElementById('select_courier');
    const postalCodeInput = document.getElementById('shipping_postal_code');
    const servicesPlaceholder = document.getElementById('services-placeholder');
    const servicesList = document.getElementById('services-list');
    const spinner = document.getElementById('shipping-loading-spinner');

    // Hidden inputs
    const inputProvince = document.getElementById('input_shipping_province');
    const inputCity = document.getElementById('input_shipping_city');
    const inputCourier = document.getElementById('input_shipping_courier');
    const inputService = document.getElementById('input_shipping_service');
    const inputCost = document.getElementById('input_shipping_cost');

    // Summary elements
    const summaryShippingCost = document.getElementById('summary-shipping-cost');
    const summaryTotalPrice = document.getElementById('summary-total-price');
    const selectedServiceBadge = document.getElementById('selected-service-badge');
    const badgeCourierService = document.getElementById('badge-courier-service');
    const badgeCourierEtd = document.getElementById('badge-courier-etd');
    const btnSubmit = document.getElementById('btn-submit-order');

    let currentCities = [];

    // Helper number format
    function formatRupiah(number) {
        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    // 1. Fetch Provinces on Load
    fetch(routes.provinces)
        .then(res => res.json())
        .then(response => {
            selectProvince.innerHTML = '<option value="">-- Pilih Provinsi --</option>';
            if (response.data && Array.isArray(response.data)) {
                response.data.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id;
                    opt.textContent = p.name;
                    if (inputProvince.value && inputProvince.value.toLowerCase() === p.name.toLowerCase()) {
                        opt.selected = true;
                    }
                    selectProvince.appendChild(opt);
                });

                if (selectProvince.value) {
                    loadCities(selectProvince.value);
                }
            }
        })
        .catch(err => {
            selectProvince.innerHTML = '<option value="">Gagal memuat provinsi</option>';
            console.error('Error fetching provinces:', err);
        });

    // 2. Province change -> Load Cities
    selectProvince.addEventListener('change', function () {
        const provinceId = this.value;
        const selectedOption = this.options[this.selectedIndex];
        inputProvince.value = selectedOption ? selectedOption.textContent : '';

        // Reset cities & shipping
        selectCity.innerHTML = '<option value="">-- Memuat kota/kabupaten... --</option>';
        selectCity.disabled = true;
        selectCourier.disabled = true;
        resetServices();

        if (provinceId) {
            loadCities(provinceId);
        }
    });

    function loadCities(provinceId) {
        fetch(`${routes.cities}?province_id=${provinceId}`)
            .then(res => res.json())
            .then(response => {
                currentCities = response.data || [];
                selectCity.innerHTML = '<option value="">-- Pilih Kota / Kabupaten --</option>';
                currentCities.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = c.full_name || c.name;
                    opt.dataset.postalCode = c.postal_code || '';
                    if (inputCity.value && (inputCity.value.toLowerCase() === c.name.toLowerCase() || inputCity.value.toLowerCase() === c.full_name.toLowerCase())) {
                        opt.selected = true;
                    }
                    selectCity.appendChild(opt);
                });
                selectCity.disabled = false;

                if (selectCity.value) {
                    selectCity.dispatchEvent(new Event('change'));
                }
            })
            .catch(err => {
                selectCity.innerHTML = '<option value="">Gagal memuat kota</option>';
                console.error('Error fetching cities:', err);
            });
    }

    // 3. City change -> auto set postal code and enable courier
    selectCity.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.value) {
            inputCity.value = selectedOption.textContent;
            if (selectedOption.dataset.postalCode && !postalCodeInput.value) {
                postalCodeInput.value = selectedOption.dataset.postalCode;
            }
            selectCourier.disabled = false;
            if (selectCourier.value) {
                calculateShipping();
            }
        } else {
            selectCourier.disabled = true;
            resetServices();
        }
    });

    // 4. Courier change -> calculate shipping cost
    selectCourier.addEventListener('change', function () {
        inputCourier.value = this.value.toUpperCase();
        if (this.value && selectCity.value) {
            calculateShipping();
        } else {
            resetServices();
        }
    });

    // 5. Calculate shipping via backend API
    function calculateShipping() {
        const cityId = selectCity.value;
        const courier = selectCourier.value;

        if (!cityId || !courier) return;

        spinner.classList.remove('d-none');
        servicesPlaceholder.textContent = 'Menghitung tarif ongkos kirim...';
        servicesPlaceholder.classList.remove('d-none');
        servicesList.classList.add('d-none');
        servicesList.innerHTML = '';
        btnSubmit.disabled = true;

        fetch(routes.calculateCost, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                destination_city_id: cityId,
                courier: courier
            })
        })
        .then(res => res.json())
        .then(response => {
            spinner.classList.add('d-none');

            if (response.status === 'success' && response.services && response.services.length > 0) {
                servicesPlaceholder.classList.add('d-none');
                servicesList.classList.remove('d-none');
                servicesList.innerHTML = '';

                response.services.forEach((s, idx) => {
                    const card = document.createElement('div');
                    card.className = 'form-check p-3 border rounded bg-white hover-shadow transition-all';
                    card.style.cursor = 'pointer';

                    const radioId = `service_${s.service}_${idx}`;
                    const isChecked = inputService.value === s.service || (idx === 0 && !inputService.value);

                    card.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <input class="form-check-input mt-0 service-radio" type="radio" name="_selected_service" id="${radioId}"
                                       value="${s.service}" data-cost="${s.cost}" data-etd="${s.etd}" data-desc="${s.description}" ${isChecked ? 'checked' : ''}>
                                <label class="form-check-label fw-bold mb-0 cursor-pointer" for="${radioId}">
                                    ${courier.toUpperCase()} - ${s.service}
                                    <span class="fw-normal text-secondary small d-block">${s.description} · Estimasi ${s.etd}</span>
                                </label>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-primary">${s.formatted_cost}</span>
                            </div>
                        </div>
                    `;

                    card.addEventListener('click', function(e) {
                        if (e.target.tagName !== 'INPUT') {
                            const radio = card.querySelector('input[type="radio"]');
                            radio.checked = true;
                            radio.dispatchEvent(new Event('change'));
                        }
                    });

                    servicesList.appendChild(card);

                    if (isChecked) {
                        selectService(s.service, s.cost, s.etd, courier.toUpperCase());
                    }
                });

                // Attach change listeners to radios
                document.querySelectorAll('.service-radio').forEach(r => {
                    r.addEventListener('change', function() {
                        if (this.checked) {
                            selectService(this.value, this.dataset.cost, this.dataset.etd, selectCourier.value.toUpperCase());
                        }
                    });
                });
            } else {
                servicesPlaceholder.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-triangle me-1"></i> Tidak ada layanan pengiriman yang tersedia untuk kurir ini. Silakan coba kurir lain.</span>';
                servicesPlaceholder.classList.remove('d-none');
            }
        })
        .catch(err => {
            spinner.classList.add('d-none');
            servicesPlaceholder.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i> Gagal menghitung ongkos kirim. Silakan coba beberapa saat lagi.</span>';
            servicesPlaceholder.classList.remove('d-none');
            console.error('Error calculating cost:', err);
        });
    }

    function selectService(serviceName, cost, etd, courierName) {
        inputService.value = serviceName;
        inputCost.value = cost;

        const numCost = parseFloat(cost) || 0;
        summaryShippingCost.textContent = formatRupiah(numCost);
        summaryShippingCost.className = 'fw-bold text-dark';

        const total = cartTotal + numCost;
        summaryTotalPrice.textContent = formatRupiah(total);

        badgeCourierService.textContent = `${courierName} - ${serviceName}`;
        badgeCourierEtd.textContent = `Estimasi pengiriman: ${etd}`;
        selectedServiceBadge.classList.remove('d-none');

        btnSubmit.disabled = false;
    }

    function resetServices() {
        inputService.value = '';
        inputCost.value = 0;
        servicesPlaceholder.textContent = 'Pilih provinsi, kota, dan kurir di atas untuk menghitung ongkir secara otomatis.';
        servicesPlaceholder.classList.remove('d-none');
        servicesList.classList.add('d-none');
        servicesList.innerHTML = '';
        summaryShippingCost.textContent = 'Pilih layanan kurir';
        summaryShippingCost.className = 'fw-semibold text-warning';
        summaryTotalPrice.textContent = formatRupiah(cartTotal);
        selectedServiceBadge.classList.add('d-none');
        btnSubmit.disabled = true;
    }
});
</script>
@endpush
