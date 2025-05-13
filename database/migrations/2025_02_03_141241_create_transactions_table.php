<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('change', 10, 2);
            $table->json('items');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Add foreign key to the 'users' table
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
