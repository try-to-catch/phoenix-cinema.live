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
        Schema::create('movies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('description');
            $table->string('duration_in_minutes');
            $table->string('age_restriction');
            $table->string('thumbnail');
            $table->timestamp('release_date')->nullable();
            $table->string('original_title')->nullable();
            $table->string('production_country')->nullable();
            $table->string('studio')->nullable();
            $table->string('main_cast')->nullable();
            $table->timestamp('start_showing')->nullable();
            $table->timestamp('end_showing')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!app()->isProduction()) {
            Schema::dropIfExists('movies');
        }
    }
};
