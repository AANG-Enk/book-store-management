<?php

use App\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table
                ->foreignIdFor(Supplier::class)
                ->nullable()
                ->after('category_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->index('supplier_id');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropConstrainedForeignId('supplier_id');
        });
    }
};
