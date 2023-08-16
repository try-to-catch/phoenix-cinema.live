<?php

namespace App\Actions\Hall;

use App\Models\HallTemplate;
use App\Models\Screening;
use Illuminate\Database\Eloquent\Model;

/**
 * This action is used to create a hall for screening based on a hall template instance
 */
class CreateHallAction
{
    public function handle(Screening $screening, HallTemplate $template): Model
    {
        $hall = $screening->hall()->create(
            ['address' => $template->address, 'number' => $template->number]
        );

        $seats = $template->seats()->get(['seat_number', 'row_number', 'type'])->toArray();

        $hall->seats()->createMany($seats);

        return $hall;
    }
}
