<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('payment_method')->default('bank_transfer');
            $table->string('bank_name')->nullable();
            $table->string('sender_name');
            $table->decimal('transfer_amount', 15, 2);
            $table->string('proof_image');
            $table->string('status')->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->unique('order_id');
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
