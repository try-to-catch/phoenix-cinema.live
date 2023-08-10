<?php

namespace App\Http\Controllers;

use App\Actions\Screening\OrganizeScreeningsAction;
use App\Http\Resources\Movie\MovieResource;
use App\Http\Resources\Screening\OrganizedScreeningListResource;
use App\Models\Movie;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Movie $movie, OrganizeScreeningsAction $organizeScreeningsAction): Response
    {
        $movie->load(['genres', 'screenings']);

        $screenings = $organizeScreeningsAction->handle($movie->screenings);

        return Inertia::render('Movies/Show', [
            'movie' => MovieResource::make($movie)->resolve(),
            'screenings' => OrganizedScreeningListResource::collection($screenings)->resolve(),
        ]);
    }
}
