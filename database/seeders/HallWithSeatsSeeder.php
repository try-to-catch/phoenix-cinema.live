<?php

namespace Database\Seeders;

use App\Actions\Seats\StoreSeatsAction;
use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallWithSeatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(StoreSeatsAction $storeSeats): void
    {
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

        $hall = Hall::factory()->create(['is_preset' => true]);
        $storeSeats->handle($hall, $seats);
    }
}
