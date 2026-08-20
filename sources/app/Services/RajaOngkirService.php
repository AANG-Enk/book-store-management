<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RajaOngkirService
{
    protected ?string $apiKey;
    protected string $baseUrl;
    protected int $originCityId;
    protected string $originCityName;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.api_key');
        $this->baseUrl = rtrim(config('services.rajaongkir.base_url', 'https://api.rajaongkir.com/starter/'), '/') . '/';
        $this->originCityId = (int) config('services.rajaongkir.origin_city_id', 22);
        $this->originCityName = (string) config('services.rajaongkir.origin_city_name', 'Kota Bandung');
    }

    public function isConfigured(): bool
    {
        return ! empty($this->apiKey) && $this->apiKey !== 'your_rajaongkir_api_key_here';
    }

    public function getOriginCityId(): int
    {
        return $this->originCityId;
    }

    public function getOriginCityName(): string
    {
        return $this->originCityName;
    }

    /**
     * Get list of provinces
     *
     * @return array<int, array{id: int, name: string}>
     */
    public function getProvinces(): array
    {
        return Cache::remember('rajaongkir_provinces', 60 * 60 * 24 * 30, function () {
            if (! $this->isConfigured()) {
                return $this->getFallbackProvinces();
            }

            try {
                $response = Http::withHeaders([
                    'key' => $this->apiKey,
                ])->timeout(2)->get($this->baseUrl . 'province');

                if ($response->successful()) {
                    $results = $response->json('rajaongkir.results', []);

                    if (! empty($results)) {
                        return collect($results)->map(fn ($item) => [
                            'id' => (int) $item['province_id'],
                            'name' => (string) $item['province'],
                        ])->sortBy('name')->values()->all();
                    }
                }
            } catch (\Throwable $e) {
                Log::info('RajaOngkir API Province offline/timeout, using local master data: ' . $e->getMessage());
            }

            return $this->getFallbackProvinces();
        });
    }

    /**
     * Get list of cities by province ID
     *
     * @return array<int, array{id: int, province_id: int, province: string, type: string, name: string, full_name: string, postal_code: string}>
     */
    public function getCities(?int $provinceId = null): array
    {
        $cacheKey = 'rajaongkir_cities_' . ($provinceId ?? 'all');

        return Cache::remember($cacheKey, 60 * 60 * 24 * 30, function () use ($provinceId) {
            if (! $this->isConfigured()) {
                return $this->getFallbackCities($provinceId);
            }

            try {
                $url = $this->baseUrl . 'city';
                $params = [];
                if ($provinceId) {
                    $params['province'] = $provinceId;
                }

                $response = Http::withHeaders([
                    'key' => $this->apiKey,
                ])->timeout(2)->get($url, $params);

                if ($response->successful()) {
                    $results = $response->json('rajaongkir.results', []);

                    if (! empty($results)) {
                        return collect($results)->map(fn ($item) => [
                            'id' => (int) $item['city_id'],
                            'province_id' => (int) $item['province_id'],
                            'province' => (string) $item['province'],
                            'type' => (string) $item['type'],
                            'name' => (string) $item['city_name'],
                            'full_name' => $item['type'] . ' ' . $item['city_name'],
                            'postal_code' => (string) ($item['postal_code'] ?? ''),
                        ])->sortBy('full_name')->values()->all();
                    }
                }
            } catch (\Throwable $e) {
                Log::info('RajaOngkir API City offline/timeout, using local master data: ' . $e->getMessage());
            }

            return $this->getFallbackCities($provinceId);
        });
    }

    /**
     * Calculate cost for a specific destination and courier
     *
     * @param int $destinationCityId
     * @param int $weightInGrams
     * @param string $courier 'jne'|'pos'|'tiki'
     * @return array<int, array{service: string, description: string, cost: int, etd: string, formatted_cost: string}>
     */
    public function calculateCost(int $destinationCityId, int $weightInGrams, string $courier = 'jne'): array
    {
        $courier = strtolower($courier);
        $weight = max(1, $weightInGrams);

        if (! $this->isConfigured()) {
            return $this->getFallbackCost($courier, $weight, $destinationCityId);
        }

        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->asForm()->timeout(2.5)->post($this->baseUrl . 'cost', [
                'origin' => $this->originCityId,
                'destination' => $destinationCityId,
                'weight' => $weight,
                'courier' => $courier,
            ]);

            if ($response->successful()) {
                $results = $response->json('rajaongkir.results.0.costs', []);

                if (! empty($results)) {
                    $services = [];
                    foreach ($results as $item) {
                        $costValue = (int) ($item['cost'][0]['value'] ?? 0);
                        $etd = (string) ($item['cost'][0]['etd'] ?? '-');

                        if (! empty($etd) && ! str_contains(strtoupper($etd), 'HARI') && is_numeric(str_replace(['-', ' '], '', $etd))) {
                            $etd .= ' hari';
                        }

                        $services[] = [
                            'service' => (string) $item['service'],
                            'description' => (string) ($item['description'] ?? $item['service']),
                            'cost' => $costValue,
                            'etd' => $etd ?: '2-3 hari',
                            'formatted_cost' => 'Rp ' . number_format($costValue, 0, ',', '.'),
                        ];
                    }

                    return $services;
                }
            }
        } catch (\Throwable $e) {
            Log::info('RajaOngkir calculateCost offline/timeout, using calculated rate: ' . $e->getMessage());
        }

        return $this->getFallbackCost($courier, $weight, $destinationCityId);
    }

    /**
     * Fallback provinces master data
     */
    public function getFallbackProvinces(): array
    {
        return [
            ['id' => 1, 'name' => 'Bali'],
            ['id' => 2, 'name' => 'Bangka Belitung'],
            ['id' => 3, 'name' => 'Banten'],
            ['id' => 4, 'name' => 'Bengkulu'],
            ['id' => 5, 'name' => 'DI Yogyakarta'],
            ['id' => 6, 'name' => 'DKI Jakarta'],
            ['id' => 7, 'name' => 'Gorontalo'],
            ['id' => 8, 'name' => 'Jambi'],
            ['id' => 9, 'name' => 'Jawa Barat'],
            ['id' => 10, 'name' => 'Jawa Tengah'],
            ['id' => 11, 'name' => 'Jawa Timur'],
            ['id' => 12, 'name' => 'Kalimantan Barat'],
            ['id' => 13, 'name' => 'Kalimantan Selatan'],
            ['id' => 14, 'name' => 'Kalimantan Tengah'],
            ['id' => 15, 'name' => 'Kalimantan Timur'],
            ['id' => 16, 'name' => 'Kalimantan Utara'],
            ['id' => 17, 'name' => 'Kepulauan Riau'],
            ['id' => 18, 'name' => 'Lampung'],
            ['id' => 19, 'name' => 'Maluku'],
            ['id' => 20, 'name' => 'Maluku Utara'],
            ['id' => 21, 'name' => 'Nusa Tenggara Barat (NTB)'],
            ['id' => 22, 'name' => 'Nusa Tenggara Timur (NTT)'],
            ['id' => 23, 'name' => 'Papua'],
            ['id' => 24, 'name' => 'Papua Barat'],
            ['id' => 25, 'name' => 'Riau'],
            ['id' => 26, 'name' => 'Sulawesi Barat'],
            ['id' => 27, 'name' => 'Sulawesi Selatan'],
            ['id' => 28, 'name' => 'Sulawesi Tengah'],
            ['id' => 29, 'name' => 'Sulawesi Tenggara'],
            ['id' => 30, 'name' => 'Sulawesi Utara'],
            ['id' => 31, 'name' => 'Sumatera Barat'],
            ['id' => 32, 'name' => 'Sumatera Selatan'],
            ['id' => 33, 'name' => 'Sumatera Utara'],
        ];
    }

    /**
     * Fallback cities master data
     */
    public function getFallbackCities(?int $provinceId = null): array
    {
        $cities = [
            // Jawa Barat (id 9) - Asal Toko di Kota Bandung (id 22)
            ['id' => 22, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Bandung', 'full_name' => 'Kota Bandung (Braga)', 'postal_code' => '40111'],
            ['id' => 23, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Bandung', 'full_name' => 'Kabupaten Bandung', 'postal_code' => '40311'],
            ['id' => 24, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Bandung Barat', 'full_name' => 'Kabupaten Bandung Barat', 'postal_code' => '40552'],
            ['id' => 54, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Bekasi', 'full_name' => 'Kota Bekasi', 'postal_code' => '17111'],
            ['id' => 55, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Bekasi', 'full_name' => 'Kabupaten Bekasi', 'postal_code' => '17530'],
            ['id' => 78, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Bogor', 'full_name' => 'Kota Bogor', 'postal_code' => '16111'],
            ['id' => 79, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Bogor', 'full_name' => 'Kabupaten Bogor', 'postal_code' => '16911'],
            ['id' => 107, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Cimahi', 'full_name' => 'Kota Cimahi', 'postal_code' => '40511'],
            ['id' => 108, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Cirebon', 'full_name' => 'Kota Cirebon', 'postal_code' => '45111'],
            ['id' => 109, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Cirebon', 'full_name' => 'Kabupaten Cirebon', 'postal_code' => '45611'],
            ['id' => 115, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Depok', 'full_name' => 'Kota Depok', 'postal_code' => '16411'],
            ['id' => 149, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Garut', 'full_name' => 'Kabupaten Garut', 'postal_code' => '44111'],
            ['id' => 211, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Karawang', 'full_name' => 'Kabupaten Karawang', 'postal_code' => '41311'],
            ['id' => 468, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Tasikmalaya', 'full_name' => 'Kota Tasikmalaya', 'postal_code' => '46111'],
            ['id' => 469, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Tasikmalaya', 'full_name' => 'Kabupaten Tasikmalaya', 'postal_code' => '46411'],
            ['id' => 440, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Sukabumi', 'full_name' => 'Kota Sukabumi', 'postal_code' => '43111'],
            ['id' => 441, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Sukabumi', 'full_name' => 'Kabupaten Sukabumi', 'postal_code' => '43311'],

            // DKI Jakarta (id 6)
            ['id' => 151, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Barat', 'full_name' => 'Kota Jakarta Barat', 'postal_code' => '11220'],
            ['id' => 152, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Pusat', 'full_name' => 'Kota Jakarta Pusat', 'postal_code' => '10110'],
            ['id' => 153, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Selatan', 'full_name' => 'Kota Jakarta Selatan', 'postal_code' => '12110'],
            ['id' => 154, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Timur', 'full_name' => 'Kota Jakarta Timur', 'postal_code' => '13330'],
            ['id' => 155, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Utara', 'full_name' => 'Kota Jakarta Utara', 'postal_code' => '14140'],

            // Banten (id 3)
            ['id' => 455, 'province_id' => 3, 'province' => 'Banten', 'type' => 'Kota', 'name' => 'Tangerang', 'full_name' => 'Kota Tangerang', 'postal_code' => '15111'],
            ['id' => 456, 'province_id' => 3, 'province' => 'Banten', 'type' => 'Kota', 'name' => 'Tangerang Selatan', 'full_name' => 'Kota Tangerang Selatan', 'postal_code' => '15311'],
            ['id' => 457, 'province_id' => 3, 'province' => 'Banten', 'type' => 'Kabupaten', 'name' => 'Tangerang', 'full_name' => 'Kabupaten Tangerang', 'postal_code' => '15711'],
            ['id' => 415, 'province_id' => 3, 'province' => 'Banten', 'type' => 'Kota', 'name' => 'Serang', 'full_name' => 'Kota Serang', 'postal_code' => '42111'],
            ['id' => 106, 'province_id' => 3, 'province' => 'Banten', 'type' => 'Kota', 'name' => 'Cilegon', 'full_name' => 'Kota Cilegon', 'postal_code' => '42411'],

            // Jawa Tengah (id 10)
            ['id' => 398, 'province_id' => 10, 'province' => 'Jawa Tengah', 'type' => 'Kota', 'name' => 'Semarang', 'full_name' => 'Kota Semarang', 'postal_code' => '50111'],
            ['id' => 399, 'province_id' => 10, 'province' => 'Jawa Tengah', 'type' => 'Kabupaten', 'name' => 'Semarang', 'full_name' => 'Kabupaten Semarang', 'postal_code' => '50511'],
            ['id' => 444, 'province_id' => 10, 'province' => 'Jawa Tengah', 'type' => 'Kota', 'name' => 'Surakarta (Solo)', 'full_name' => 'Kota Surakarta (Solo)', 'postal_code' => '57111'],
            ['id' => 249, 'province_id' => 10, 'province' => 'Jawa Tengah', 'type' => 'Kota', 'name' => 'Magelang', 'full_name' => 'Kota Magelang', 'postal_code' => '56111'],
            ['id' => 349, 'province_id' => 10, 'province' => 'Jawa Tengah', 'type' => 'Kota', 'name' => 'Pekalongan', 'full_name' => 'Kota Pekalongan', 'postal_code' => '51111'],
            ['id' => 472, 'province_id' => 10, 'province' => 'Jawa Tengah', 'type' => 'Kota', 'name' => 'Tegal', 'full_name' => 'Kota Tegal', 'postal_code' => '52111'],
            ['id' => 41, 'province_id' => 10, 'province' => 'Jawa Tengah', 'type' => 'Kabupaten', 'name' => 'Banyumas (Purwokerto)', 'full_name' => 'Kabupaten Banyumas (Purwokerto)', 'postal_code' => '53111'],

            // DI Yogyakarta (id 5)
            ['id' => 501, 'province_id' => 5, 'province' => 'DI Yogyakarta', 'type' => 'Kota', 'name' => 'Yogyakarta', 'full_name' => 'Kota Yogyakarta', 'postal_code' => '55111'],
            ['id' => 419, 'province_id' => 5, 'province' => 'DI Yogyakarta', 'type' => 'Kabupaten', 'name' => 'Sleman', 'full_name' => 'Kabupaten Sleman', 'postal_code' => '55511'],
            ['id' => 39, 'province_id' => 5, 'province' => 'DI Yogyakarta', 'type' => 'Kabupaten', 'name' => 'Bantul', 'full_name' => 'Kabupaten Bantul', 'postal_code' => '55711'],
            ['id' => 150, 'province_id' => 5, 'province' => 'DI Yogyakarta', 'type' => 'Kabupaten', 'name' => 'Gunung Kidul', 'full_name' => 'Kabupaten Gunung Kidul', 'postal_code' => '55811'],
            ['id' => 210, 'province_id' => 5, 'province' => 'DI Yogyakarta', 'type' => 'Kabupaten', 'name' => 'Kulon Progo', 'full_name' => 'Kabupaten Kulon Progo', 'postal_code' => '55611'],

            // Jawa Timur (id 11)
            ['id' => 444, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kota', 'name' => 'Surabaya', 'full_name' => 'Kota Surabaya', 'postal_code' => '60111'],
            ['id' => 255, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kota', 'name' => 'Malang', 'full_name' => 'Kota Malang', 'postal_code' => '65111'],
            ['id' => 256, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kabupaten', 'name' => 'Malang', 'full_name' => 'Kabupaten Malang', 'postal_code' => '65151'],
            ['id' => 418, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kabupaten', 'name' => 'Sidoarjo', 'full_name' => 'Kabupaten Sidoarjo', 'postal_code' => '61211'],
            ['id' => 160, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kabupaten', 'name' => 'Gresik', 'full_name' => 'Kabupaten Gresik', 'postal_code' => '61111'],
            ['id' => 197, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kota', 'name' => 'Kediri', 'full_name' => 'Kota Kediri', 'postal_code' => '64111'],
            ['id' => 178, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kabupaten', 'name' => 'Jember', 'full_name' => 'Kabupaten Jember', 'postal_code' => '68111'],
            ['id' => 42, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kabupaten', 'name' => 'Banyuwangi', 'full_name' => 'Kabupaten Banyuwangi', 'postal_code' => '68411'],

            // Bali (id 1)
            ['id' => 114, 'province_id' => 1, 'province' => 'Bali', 'type' => 'Kota', 'name' => 'Denpasar', 'full_name' => 'Kota Denpasar', 'postal_code' => '80111'],
            ['id' => 17, 'province_id' => 1, 'province' => 'Bali', 'type' => 'Kabupaten', 'name' => 'Badung (Kuta)', 'full_name' => 'Kabupaten Badung (Kuta)', 'postal_code' => '80351'],
            ['id' => 128, 'province_id' => 1, 'province' => 'Bali', 'type' => 'Kabupaten', 'name' => 'Gianyar (Ubud)', 'full_name' => 'Kabupaten Gianyar (Ubud)', 'postal_code' => '80511'],

            // Nusa Tenggara Timur (id 22)
            ['id' => 213, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kota', 'name' => 'Kupang', 'full_name' => 'Kota Kupang', 'postal_code' => '85111'],
            ['id' => 214, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kabupaten', 'name' => 'Kupang', 'full_name' => 'Kabupaten Kupang', 'postal_code' => '85311'],
            ['id' => 127, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kabupaten', 'name' => 'Ende', 'full_name' => 'Kabupaten Ende', 'postal_code' => '86311'],
            ['id' => 258, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kabupaten', 'name' => 'Manggarai', 'full_name' => 'Kabupaten Manggarai', 'postal_code' => '86511'],
            ['id' => 424, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kabupaten', 'name' => 'Sikka (Maumere)', 'full_name' => 'Kabupaten Sikka (Maumere)', 'postal_code' => '86111'],

            // Nusa Tenggara Barat (id 21)
            ['id' => 270, 'province_id' => 21, 'province' => 'Nusa Tenggara Barat', 'type' => 'Kota', 'name' => 'Mataram', 'full_name' => 'Kota Mataram', 'postal_code' => '83111'],
            ['id' => 236, 'province_id' => 21, 'province' => 'Nusa Tenggara Barat', 'type' => 'Kabupaten', 'name' => 'Lombok Barat', 'full_name' => 'Kabupaten Lombok Barat', 'postal_code' => '83311'],

            // Sumatera Utara (id 33)
            ['id' => 278, 'province_id' => 33, 'province' => 'Sumatera Utara', 'type' => 'Kota', 'name' => 'Medan', 'full_name' => 'Kota Medan', 'postal_code' => '20111'],

            // Sumatera Barat (id 31)
            ['id' => 318, 'province_id' => 31, 'province' => 'Sumatera Barat', 'type' => 'Kota', 'name' => 'Padang', 'full_name' => 'Kota Padang', 'postal_code' => '25111'],

            // Sumatera Selatan (id 32)
            ['id' => 327, 'province_id' => 32, 'province' => 'Sumatera Selatan', 'type' => 'Kota', 'name' => 'Palembang', 'full_name' => 'Kota Palembang', 'postal_code' => '30111'],

            // Lampung (id 18)
            ['id' => 21, 'province_id' => 18, 'province' => 'Lampung', 'type' => 'Kota', 'name' => 'Bandar Lampung', 'full_name' => 'Kota Bandar Lampung', 'postal_code' => '35111'],

            // Kalimantan Timur (id 15)
            ['id' => 391, 'province_id' => 15, 'province' => 'Kalimantan Timur', 'type' => 'Kota', 'name' => 'Samarinda', 'full_name' => 'Kota Samarinda', 'postal_code' => '75111'],
            ['id' => 19, 'province_id' => 15, 'province' => 'Kalimantan Timur', 'type' => 'Kota', 'name' => 'Balikpapan', 'full_name' => 'Kota Balikpapan', 'postal_code' => '76111'],

            // Sulawesi Selatan (id 27)
            ['id' => 254, 'province_id' => 27, 'province' => 'Sulawesi Selatan', 'type' => 'Kota', 'name' => 'Makassar', 'full_name' => 'Kota Makassar', 'postal_code' => '90111'],

            // Papua (id 23)
            ['id' => 176, 'province_id' => 23, 'province' => 'Papua', 'type' => 'Kota', 'name' => 'Jayapura', 'full_name' => 'Kota Jayapura', 'postal_code' => '99111'],
        ];

        if ($provinceId) {
            $filtered = collect($cities)->where('province_id', $provinceId)->values()->all();
            if (! empty($filtered)) {
                return $filtered;
            }

            // Fallback generic city for other provinces
            $province = collect($this->getFallbackProvinces())->firstWhere('id', $provinceId);
            $provName = $province['name'] ?? 'Provinsi';

            return [
                ['id' => $provinceId * 10, 'province_id' => $provinceId, 'province' => $provName, 'type' => 'Kota', 'name' => 'Pusat Kota ' . $provName, 'full_name' => 'Kota ' . $provName, 'postal_code' => '10000'],
                ['id' => $provinceId * 10 + 1, 'province_id' => $provinceId, 'province' => $provName, 'type' => 'Kabupaten', 'name' => 'Wilayah ' . $provName, 'full_name' => 'Kabupaten ' . $provName, 'postal_code' => '10001'],
            ];
        }

        return $cities;
    }

    /**
     * Fallback cost calculation
     */
    public function getFallbackCost(string $courier, int $weightInGrams, int $destinationCityId = 0): array
    {
        $kg = max(1, (int) ceil($weightInGrams / 1000));

        // Intrajabar / Jabodetabek distance multiplier
        $isJabar = in_array($destinationCityId, [22, 23, 24, 107, 78, 54, 115, 151, 152, 153, 154, 155], true);
        $base = $isJabar ? 11000 : 22000;

        return match ($courier) {
            'pos' => [
                [
                    'service' => 'Pos Reguler',
                    'description' => 'Pos Indonesia Reguler',
                    'cost' => $base * $kg,
                    'etd' => $isJabar ? '1-2 hari' : '2-4 hari',
                    'formatted_cost' => 'Rp ' . number_format($base * $kg, 0, ',', '.'),
                ],
                [
                    'service' => 'Pos Next Day',
                    'description' => 'Pos Indonesia Kilat Khusus',
                    'cost' => ($base + 15000) * $kg,
                    'etd' => '1 hari',
                    'formatted_cost' => 'Rp ' . number_format(($base + 15000) * $kg, 0, ',', '.'),
                ],
            ],
            'tiki' => [
                [
                    'service' => 'REG',
                    'description' => 'TIKI Regular Service',
                    'cost' => ($base + 2000) * $kg,
                    'etd' => $isJabar ? '1-2 hari' : '2-3 hari',
                    'formatted_cost' => 'Rp ' . number_format(($base + 2000) * $kg, 0, ',', '.'),
                ],
                [
                    'service' => 'ONS',
                    'description' => 'TIKI Over Night Service',
                    'cost' => ($base + 18000) * $kg,
                    'etd' => '1 hari',
                    'formatted_cost' => 'Rp ' . number_format(($base + 18000) * $kg, 0, ',', '.'),
                ],
            ],
            default => [ // jne
                [
                    'service' => 'REG',
                    'description' => 'JNE Layanan Reguler',
                    'cost' => $base * $kg,
                    'etd' => $isJabar ? '1-2 hari' : '2-3 hari',
                    'formatted_cost' => 'Rp ' . number_format($base * $kg, 0, ',', '.'),
                ],
                [
                    'service' => 'OKE',
                    'description' => 'JNE Ongkos Kirim Ekonomis',
                    'cost' => max(9000, ($base - 3000)) * $kg,
                    'etd' => $isJabar ? '2-3 hari' : '3-5 hari',
                    'formatted_cost' => 'Rp ' . number_format(max(9000, ($base - 3000)) * $kg, 0, ',', '.'),
                ],
                [
                    'service' => 'YES',
                    'description' => 'JNE Yakin Esok Sampai',
                    'cost' => ($base + 16000) * $kg,
                    'etd' => '1 hari',
                    'formatted_cost' => 'Rp ' . number_format(($base + 16000) * $kg, 0, ',', '.'),
                ],
            ],
        };
    }
}
