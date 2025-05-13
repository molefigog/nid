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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number')->unique(); // <- semicolon added here
            $table->string('customer_name')->nullable();
            $table->json('items');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
