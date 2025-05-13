<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->date('date');
            $table->integer('opening_stock');
            $table->integer('closing_stock')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_stocks');
    }
};
