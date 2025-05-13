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
        Schema::create('sold_items_collections', function (Blueprint $table) {
            $table->id();
            $table->json('items');
            $table->string('invoice_number')->unique();
            $table->decimal('total', 10, 2);
            $table->decimal('change', 10, 2);
            $table->json('payment_methods');
            $table->string('original_receipt_date');
            $table->decimal('cash_paid', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sold_items_collections');
    }
};
