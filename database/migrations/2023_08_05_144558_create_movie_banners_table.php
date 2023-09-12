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
        Schema::create('movie_banners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('movie_id')->constrained()->cascadeOnDelete();
            $table->string('image');
            $table->string('description');
            $table->string('fact');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('movie_banners');
        }
    }
};
