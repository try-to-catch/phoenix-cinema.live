<?php

namespace App\Actions\Screening;

use App\Http\Requests\Admin\Screening\StoreScreeningRequest;
use App\Models\Movie;
use App\Models\Screening;
use Carbon\Carbon;

class CreateScreeningAction
{
    public function handle(StoreScreeningRequest $request): Screening
    {
        $newScreening = $request->validated();
        $movie = Movie::find($newScreening['movie_id']);
        unset($newScreening['hall_template_id'],$newScreening['movie_id']);

        $newScreening['start_time'] = Carbon::parse($newScreening['start_time']);
        $newScreening['end_time'] = $newScreening['start_time']->addMinutes($movie->duration_in_minutes);

        return $movie->screenings()->create($newScreening);
    }
}
