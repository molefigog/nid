<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['increment', 'decrement']);
            $table->integer('quantity');
            $table->enum('reason', ['new stock', 'damage', 'stolen', 'returned']);
            $table->timestamp('adjusted_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_adjustments');
    }
};
