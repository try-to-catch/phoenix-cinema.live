<?php

namespace Database\Factories;

use App\Models\HallTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HallTemplate>
 */
class HallTemplateFactory extends HallFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->numberBetween(1, 10),
            'address' => fake()->address(),
            'is_available' => true,
        ];
    }
}
