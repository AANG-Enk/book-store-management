<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function __construct(
        protected MidtransService $midtransService
    ) {}

    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::info('Midtrans Webhook Notification Received:', [
            'order_id' => $payload['order_id'] ?? null,
            'status' => $payload['transaction_status'] ?? null,
        ]);

        $result = $this->midtransService->handleNotification($payload);

        if ($result['status'] === 'error') {
            return response()->json($result, 400);
        }

        return response()->json($result, 200);
    }
}
