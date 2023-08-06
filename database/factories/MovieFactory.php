<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $thumbnailPath = public_path('/images/defaults/joker.jpg');

        if (!file_exists(storage_path('app/public/images/movies'))) {
            mkdir(storage_path('app/public/images/movies'), 0777, true);
        }

        $storagePath = "images/movies/" . Str::random(24) . '.jpg';
        copy($thumbnailPath, storage_path("app/public/$storagePath"));

        $startingDate = now()->subMonths(rand(-6, 6))->subDays(rand(1, 30));

        return [
            'title' => fake()->sentence(rand(2, 4)),
            'description' => fake()->paragraph(4),
            'priority' => rand(1, 100),
            'duration_in_minutes' => fake()->numberBetween(60, 150),
            'age_restriction' => collect(Movie::AGE_RESTRICTIONS)->random(),
            'thumbnail' => $storagePath,
            'release_year' => fake()->year(),
            'original_title' => fake()->words(rand(1, 3), true),
            'director' => fake()->words(2, true),
            'production_country' => fake()->country(),
            'studio' => fake()->company(),
            'main_cast' => fake()->words(5, true),
            'start_showing' => $startingDate->format('Y-m-d'),
            'end_showing' => $startingDate->addMonths(rand(1, 3))->addDays(rand(1, 30))->format('Y-m-d'),
        ];
    }
}
