<?php

namespace Database\Factories;

use App\Actions\Images\StoreThumbnailAction;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\File;

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
        $thumbnail = new File($thumbnailPath);
        $storeThumbnailAction = new StoreThumbnailAction();
        $storagePath = $storeThumbnailAction->handle($thumbnail, 'movies');

        $startingDate = now()->subMonths(rand(1, 3))->subDays(rand(1, 30));

        return [
            'title' => fake()->sentence(rand(2, 4)),
            'description' => fake()->paragraph(4),
            'duration_in_minutes' => fake()->numberBetween(60, 150),
            'age_restriction' => (['G', 'PG', 'PG-13', 'R', 'NC-17'][rand(0, 4)]),
            'thumbnail' => $storagePath,
            'release_date' => $startingDate->subDays(rand(5, 10))->startOfDay(),
            'original_title' => fake()->words(rand(1, 3), true),
            'production_country' => fake()->country(),
            'studio' => fake()->company(),
            'main_cast' => fake()->words(5, true),
            'start_showing' => $startingDate->startOfDay(),
            'end_showing' => $startingDate->addMonths(rand(1, 3))->addDays(rand(1, 30))->endOfDay(),
        ];
    }
}
