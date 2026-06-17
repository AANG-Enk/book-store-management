<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->year('publication_year')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->decimal('price', 15, 2)->default(0);
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category_id', 'is_active']);
            $table->index(['title', 'author']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
