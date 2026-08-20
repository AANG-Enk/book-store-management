<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Services\RajaOngkirService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function __construct(
        protected RajaOngkirService $rajaOngkirService
    ) {}

    public function provinces(): JsonResponse
    {
        $provinces = $this->rajaOngkirService->getProvinces();

        return response()->json([
            'status' => 'success',
            'data' => $provinces,
        ]);
    }

    public function cities(Request $request): JsonResponse
    {
        $provinceId = $request->integer('province_id');

        $cities = $this->rajaOngkirService->getCities($provinceId ?: null);

        return response()->json([
            'status' => 'success',
            'data' => $cities,
        ]);
    }

    public function calculateCost(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'destination_city_id' => ['required', 'integer'],
            'courier' => ['required', 'string', 'in:jne,pos,tiki'],
        ]);

        $cartItems = CartItem::query()
            ->with('book')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Keranjang belanja masih kosong.',
            ], 422);
        }

        $totalWeight = $cartItems->sum(function (CartItem $item) {
            $bookWeight = (int) ($item->book->weight ?: 250);

            return $item->quantity * $bookWeight;
        });

        $totalWeight = max(1, $totalWeight);

        $services = $this->rajaOngkirService->calculateCost(
            destinationCityId: (int) $validated['destination_city_id'],
            weightInGrams: $totalWeight,
            courier: (string) $validated['courier']
        );

        $formattedWeight = $totalWeight >= 1000
            ? rtrim(rtrim(number_format($totalWeight / 1000, 2, ',', '.'), '0'), ',') . ' kg'
            : $totalWeight . ' gram';

        return response()->json([
            'status' => 'success',
            'weight' => $totalWeight,
            'formatted_weight' => $formattedWeight,
            'origin' => $this->rajaOngkirService->getOriginCityName(),
            'courier' => strtoupper($validated['courier']),
            'services' => $services,
        ]);
    }
}
