<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): Response
    {
        $movie->load('genres');
        return Inertia::render('Movies/Show', [
            'movie' => $movie->toArray(),
            'screenings' => $movie->screenings()->get()->toArray(),
        ]);
    }
}
