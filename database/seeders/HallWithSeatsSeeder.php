<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallWithSeatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $halls = Hall::factory()->count(3)->create();

        $seats = [
            [
                ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard']
            ],
            [
                ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard']
            ],
            [
                ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium']
            ],
            [
                ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium']
            ],
        ];

//        $halls->each(function (Hall $hall) use ($seats) {
//            $hall->seats()->createMany($seats);
//        });
    }
}
