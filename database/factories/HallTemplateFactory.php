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
            'title' => fake()->words(rand(1, 3), true),
            'is_available' => true,
        ];
    }
}
