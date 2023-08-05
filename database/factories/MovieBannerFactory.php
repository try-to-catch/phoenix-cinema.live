<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\MovieBanner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<MovieBanner>
 */
class MovieBannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $thumbnailPath = public_path('/images/defaults/banner.jpg');

        if (!file_exists(storage_path('app/public/banners/movies'))) {
            mkdir(storage_path('app/public/banners/movies'), 0777, true);
        }

        $storagePath = "banners/movies/" . Str::random(24) . '.jpg';
        copy($thumbnailPath, storage_path("app/public/$storagePath"));

        return [
            'movie_id' => Movie::missingBanner()->first()->id ?? MovieFactory::new(),
            'image' => $storagePath,
            'description' => fake()->sentences(2, true),
            'fact' => fake()->sentences(1, true),
        ];
    }
}
