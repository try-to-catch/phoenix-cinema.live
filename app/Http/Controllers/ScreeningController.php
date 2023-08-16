<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\Seat\SeatResource;
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
        $screening->load('seats');
        return Inertia::render('Screenings/Show',
            [
                'seating_plan' => SeatResource::make($screening->seats)->resolve(),
                'screening' => $screening,
            ]);
    }
}
