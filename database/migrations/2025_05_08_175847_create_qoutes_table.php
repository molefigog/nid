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
        Schema::create('qoutes', function (Blueprint $table) {
            $table->id();
            $table->string('qoutation_number')->unique();
            $table->decimal('total', 10, 2);
            $table->json('items');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qoutes');
    }
};
