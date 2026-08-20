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
        $this->originCityId = (int) config('services.rajaongkir.origin_city_id', 213);
        $this->originCityName = (string) config('services.rajaongkir.origin_city_name', 'Kupang');
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
     * Get list of provinces (cached for 30 days)
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
                ])->timeout(10)->get($this->baseUrl . 'province');

                if ($response->successful()) {
                    $results = $response->json('rajaongkir.results', []);

                    return collect($results)->map(fn ($item) => [
                        'id' => (int) $item['province_id'],
                        'name' => (string) $item['province'],
                    ])->sortBy('name')->values()->all();
                }

                Log::warning('RajaOngkir API Province error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            } catch (\Throwable $e) {
                Log::error('RajaOngkir API Province Exception: ' . $e->getMessage());
            }

            return $this->getFallbackProvinces();
        });
    }

    /**
     * Get list of cities by province ID (cached for 30 days)
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
                ])->timeout(10)->get($url, $params);

                if ($response->successful()) {
                    $results = $response->json('rajaongkir.results', []);

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

                Log::warning('RajaOngkir API City error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            } catch (\Throwable $e) {
                Log::error('RajaOngkir API City Exception: ' . $e->getMessage());
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
            return $this->getFallbackCost($courier, $weight);
        }

        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey,
            ])->asForm()->timeout(12)->post($this->baseUrl . 'cost', [
                'origin' => $this->originCityId,
                'destination' => $destinationCityId,
                'weight' => $weight,
                'courier' => $courier,
            ]);

            if ($response->successful()) {
                $results = $response->json('rajaongkir.results.0.costs', []);

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

            Log::warning('RajaOngkir calculateCost error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error('RajaOngkir calculateCost Exception: ' . $e->getMessage());
        }

        return $this->getFallbackCost($courier, $weight);
    }

    /**
     * Fallback provinces for development/demo when API key is missing
     */
    protected function getFallbackProvinces(): array
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
            ['id' => 21, 'name' => 'Nusa Tenggara Barat'],
            ['id' => 22, 'name' => 'Nusa Tenggara Timur'],
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
     * Fallback cities for development/demo when API key is missing
     */
    protected function getFallbackCities(?int $provinceId = null): array
    {
        $cities = [
            // DKI Jakarta (id 6)
            ['id' => 151, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Barat', 'full_name' => 'Kota Jakarta Barat', 'postal_code' => '11220'],
            ['id' => 152, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Pusat', 'full_name' => 'Kota Jakarta Pusat', 'postal_code' => '10110'],
            ['id' => 153, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Selatan', 'full_name' => 'Kota Jakarta Selatan', 'postal_code' => '12110'],
            ['id' => 154, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Timur', 'full_name' => 'Kota Jakarta Timur', 'postal_code' => '13330'],
            ['id' => 155, 'province_id' => 6, 'province' => 'DKI Jakarta', 'type' => 'Kota', 'name' => 'Jakarta Utara', 'full_name' => 'Kota Jakarta Utara', 'postal_code' => '14140'],

            // Jawa Barat (id 9)
            ['id' => 22, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Bandung', 'full_name' => 'Kota Bandung', 'postal_code' => '40111'],
            ['id' => 23, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kabupaten', 'name' => 'Bandung', 'full_name' => 'Kabupaten Bandung', 'postal_code' => '40311'],
            ['id' => 54, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Bekasi', 'full_name' => 'Kota Bekasi', 'postal_code' => '17111'],
            ['id' => 78, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Bogor', 'full_name' => 'Kota Bogor', 'postal_code' => '16111'],
            ['id' => 115, 'province_id' => 9, 'province' => 'Jawa Barat', 'type' => 'Kota', 'name' => 'Depok', 'full_name' => 'Kota Depok', 'postal_code' => '16411'],

            // Jawa Tengah (id 10)
            ['id' => 398, 'province_id' => 10, 'province' => 'Jawa Tengah', 'type' => 'Kota', 'name' => 'Semarang', 'full_name' => 'Kota Semarang', 'postal_code' => '50111'],
            ['id' => 444, 'province_id' => 10, 'province' => 'Jawa Tengah', 'type' => 'Kota', 'name' => 'Surakarta (Solo)', 'full_name' => 'Kota Surakarta', 'postal_code' => '57111'],

            // Jawa Timur (id 11)
            ['id' => 444, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kota', 'name' => 'Surabaya', 'full_name' => 'Kota Surabaya', 'postal_code' => '60111'],
            ['id' => 255, 'province_id' => 11, 'province' => 'Jawa Timur', 'type' => 'Kota', 'name' => 'Malang', 'full_name' => 'Kota Malang', 'postal_code' => '65111'],

            // DI Yogyakarta (id 5)
            ['id' => 501, 'province_id' => 5, 'province' => 'DI Yogyakarta', 'type' => 'Kota', 'name' => 'Yogyakarta', 'full_name' => 'Kota Yogyakarta', 'postal_code' => '55111'],
            ['id' => 419, 'province_id' => 5, 'province' => 'DI Yogyakarta', 'type' => 'Kabupaten', 'name' => 'Sleman', 'full_name' => 'Kabupaten Sleman', 'postal_code' => '55511'],

            // NTT (id 22) - Asal Toko NusaCendana
            ['id' => 213, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kota', 'name' => 'Kupang', 'full_name' => 'Kota Kupang', 'postal_code' => '85111'],
            ['id' => 214, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kabupaten', 'name' => 'Kupang', 'full_name' => 'Kabupaten Kupang', 'postal_code' => '85311'],
            ['id' => 127, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kabupaten', 'name' => 'Ende', 'full_name' => 'Kabupaten Ende', 'postal_code' => '86311'],
            ['id' => 258, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kabupaten', 'name' => 'Manggarai', 'full_name' => 'Kabupaten Manggarai', 'postal_code' => '86511'],
            ['id' => 424, 'province_id' => 22, 'province' => 'Nusa Tenggara Timur', 'type' => 'Kabupaten', 'name' => 'Sikka (Maumere)', 'full_name' => 'Kabupaten Sikka', 'postal_code' => '86111'],
        ];

        if ($provinceId) {
            return collect($cities)->where('province_id', $provinceId)->values()->all();
        }

        return $cities;
    }

    /**
     * Fallback cost calculation for development/demo when API key is missing
     */
    protected function getFallbackCost(string $courier, int $weightInGrams): array
    {
        $kg = ceil($weightInGrams / 1000);

        return match ($courier) {
            'pos' => [
                [
                    'service' => 'Pos Reguler',
                    'description' => 'Pos Indonesia Reguler',
                    'cost' => 22000 * $kg,
                    'etd' => '2-4 hari',
                    'formatted_cost' => 'Rp ' . number_format(22000 * $kg, 0, ',', '.'),
                ],
                [
                    'service' => 'Pos Next Day',
                    'description' => 'Pos Indonesia Kilat Khusus',
                    'cost' => 38000 * $kg,
                    'etd' => '1-2 hari',
                    'formatted_cost' => 'Rp ' . number_format(38000 * $kg, 0, ',', '.'),
                ],
            ],
            'tiki' => [
                [
                    'service' => 'REG',
                    'description' => 'TIKI Regular Service',
                    'cost' => 24000 * $kg,
                    'etd' => '2-3 hari',
                    'formatted_cost' => 'Rp ' . number_format(24000 * $kg, 0, ',', '.'),
                ],
                [
                    'service' => 'ONS',
                    'description' => 'TIKI Over Night Service',
                    'cost' => 42000 * $kg,
                    'etd' => '1 hari',
                    'formatted_cost' => 'Rp ' . number_format(42000 * $kg, 0, ',', '.'),
                ],
            ],
            default => [ // jne
                [
                    'service' => 'REG',
                    'description' => 'JNE Layanan Reguler',
                    'cost' => 25000 * $kg,
                    'etd' => '2-3 hari',
                    'formatted_cost' => 'Rp ' . number_format(25000 * $kg, 0, ',', '.'),
                ],
                [
                    'service' => 'OKE',
                    'description' => 'JNE Ongkos Kirim Ekonomis',
                    'cost' => 19000 * $kg,
                    'etd' => '3-5 hari',
                    'formatted_cost' => 'Rp ' . number_format(19000 * $kg, 0, ',', '.'),
                ],
                [
                    'service' => 'YES',
                    'description' => 'JNE Yakin Esok Sampai',
                    'cost' => 45000 * $kg,
                    'etd' => '1 hari',
                    'formatted_cost' => 'Rp ' . number_format(45000 * $kg, 0, ',', '.'),
                ],
            ],
        };
    }
}
