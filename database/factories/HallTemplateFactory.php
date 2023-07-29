<?php

namespace Database\Factories;

use App\Actions\Seats\StoreSeatsAction;
use App\Models\HallTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HallTemplate>
 */
class HallTemplateFactory extends Factory
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

    public function configure(): HallTemplateFactory
    {
        /** @var StoreSeatsAction $storeSeats */
        $storeSeats = app(StoreSeatsAction::class);

        return $this->afterCreating(function (HallTemplate $hall) use ($storeSeats) {
            $seats = [
                [
                    ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard']
                ],
                [
                    ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'],
                ],
                [
                    ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium'],
                ]
            ];

            $storeSeats->handle($hall, $seats);
        });
    }
}
