<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->foreignUuid('hall_id')->constrained()->cascadeOnDelete();
            $table->integer('seat_number');
            $table->integer('row_number');
            $table->enum('type', ['blank', 'vip', 'standard']);
            $table->boolean('is_taken')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('seats');
        }
    }
};