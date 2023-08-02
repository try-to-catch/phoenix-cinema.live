<?php

namespace Database\Factories;

use App\Models\Hall;
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
        return [
            'movie_id' => Movie::first()->id ?? MovieFactory::new(),
            'hall_id' => Hall::first()->id ?? HallFactory::new(),
            'start_time' => fake()->dateTimeBetween('now', '+1 week'),
            'end_time' => fake()->dateTimeBetween('+1 week', '+2 week'),
            'standard_seat_price' => fake()->numberBetween(100, 200),
            'premium_seat_price' => fake()->numberBetween(200, 300),
        ];
    }
}
