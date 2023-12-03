<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Screening>
 */
class ScreeningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $startTime = now()->addDays(rand(1, 14))->startOfHour()->addHours(rand(-23, 23));

        return [
            'movie_id' => Movie::first()->id ?? MovieFactory::new(),
            'start_time' => $startTime,
            'end_time' => $startTime->copy()->addMinutes(rand(90, 180)),
            'standard_seat_price' => fake()->numberBetween(100, 200),
            'premium_seat_price' => fake()->numberBetween(200, 300),
        ];
    }
}
