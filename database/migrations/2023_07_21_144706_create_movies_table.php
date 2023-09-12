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
        Schema::create('movies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('description');
            $table->tinyInteger('priority');
            $table->smallInteger('duration_in_minutes');
            $table->string('age_restriction');
            $table->string('thumbnail');
            $table->string('director');
            $table->string('production_country');
            $table->string('main_cast');
            $table->year('release_year')->nullable();
            $table->string('original_title')->nullable();
            $table->string('studio')->nullable();
            $table->date('start_showing')->nullable();
            $table->date('end_showing')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! app()->isProduction()) {
            Schema::dropIfExists('movies');
        }
    }
};
