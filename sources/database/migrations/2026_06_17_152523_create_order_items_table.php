<?php

use App\Models\Book;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Book::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('book_title');
            $table->decimal('book_price', 15, 2);
            $table->unsignedInteger('quantity');
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->index(['order_id', 'book_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
