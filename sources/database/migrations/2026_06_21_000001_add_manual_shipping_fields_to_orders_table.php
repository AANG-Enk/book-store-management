<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal_price', 15, 2)->default(0);
            $table->string('shipping_province')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postal_code', 20)->nullable();
            $table->string('shipping_courier', 100)->nullable();
            $table->string('shipping_service', 100)->nullable();
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->string('tracking_number', 100)->nullable();
            $table->timestamp('shipping_confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
        });

        DB::table('orders')->update([
            'subtotal_price' => DB::raw('total_price'),
        ]);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal_price',
                'shipping_province',
                'shipping_city',
                'shipping_postal_code',
                'shipping_courier',
                'shipping_service',
                'shipping_cost',
                'tracking_number',
                'shipping_confirmed_at',
                'shipped_at',
            ]);
        });
    }
};
