<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\Seat\SeatResource;
use App\Http\Resources\Screening\ScreeningInfoResource;
use App\Models\Screening;
use Inertia\Inertia;
use Inertia\Response;

class ScreeningController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Screening $screening): Response
    {
        $screening->load(['seats', 'movie', 'hall']);

        return Inertia::render('Screenings/Show',
            [
                'seatingPlan' => SeatResource::make($screening->seats)->resolve(),
                'screening' => ScreeningInfoResource::make($screening)->resolve(),
            ]);
    }
}
