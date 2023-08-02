<?php

namespace App\Actions\Hall;

use App\Models\Hall;
use App\Models\HallTemplate;
use App\Models\Screening;

/**
 * This action is used to create a hall for screening based on a hall template instance
 */
class CreateHallAction
{
    public function handle(Screening $screening, HallTemplate $template): Hall
    {
        /** @var Hall $hall */
        $hall = $screening->hall()->create(['title' => $template->title]);

        $seats = $template->seats()->get(['seat_number', 'row_number', 'type'])->toArray();

        $hall->seats()->createMany($seats);

        return $hall;
    }
}
