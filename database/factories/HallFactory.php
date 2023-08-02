<?php

namespace Database\Factories;

use App\Actions\Seats\StoreSeatsAction;
use App\Models\Hall;
use App\Models\Screening;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hall>
 */
class HallFactory extends Factory
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
            'screening_id' => Screening::first()->id ?? ScreeningFactory::new(),
        ];
    }

    public function configure(): Factory
    {
        /** @var StoreSeatsAction $storeSeats */
        $storeSeats = app(StoreSeatsAction::class);

        return $this->afterCreating(fn($hall) => $storeSeats->handle($hall));
    }
}
