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
     * Extend the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return tap(parent::definition(), function (array &$attributes) {
            $attributes['is_available'] = true;
        });
    }
}
