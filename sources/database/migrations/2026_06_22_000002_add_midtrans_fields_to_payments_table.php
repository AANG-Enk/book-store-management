<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('sender_name')->nullable()->change();
            $table->string('proof_image')->nullable()->change();
            $table->decimal('transfer_amount', 15, 2)->nullable()->change();

            $table->string('snap_token')->nullable()->after('proof_image');
            $table->string('transaction_id')->nullable()->after('snap_token');
            $table->string('payment_type')->nullable()->after('transaction_id');
            $table->string('transaction_status')->nullable()->after('payment_type');
            $table->timestamp('transaction_time')->nullable()->after('transaction_status');
            $table->json('payment_payload')->nullable()->after('transaction_time');

            $table->index(['transaction_id', 'transaction_status']);
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['transaction_id', 'transaction_status']);
            $table->dropColumn([
                'snap_token',
                'transaction_id',
                'payment_type',
                'transaction_status',
                'transaction_time',
                'payment_payload',
            ]);
        });
    }
};
