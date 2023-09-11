<?php

namespace App\Http\Controllers;

use App\Actions\Screening\OrganizeScreeningsAction;
use App\Actions\Shared\FormatPaginationMetaLinksAction;
use App\Http\Resources\Movie\MovieListResource;
use App\Http\Resources\Movie\MovieResource;
use App\Http\Resources\Screening\OrganizedScreeningListResource;
use App\Models\Movie;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FormatPaginationMetaLinksAction $formatLinksAction): Response
    {
        $selectedColumns = ['id', 'title', 'slug', 'thumbnail', 'age_restriction', 'director', 'start_showing', 'end_showing'];

        //TODO add caching of the movies and future movies
        $movies = Movie::currentlyScreeningWithGenres()->orderByDesc('priority')->get($selectedColumns);
        $futureMovies = Movie::screeningSoonWithGenres()->orderBy('start_showing')->select($selectedColumns)->paginate(18);

        return Inertia::render('Movies/Index', [
            'movies' => MovieListResource::collection($movies)->resolve(),
            'futureMovies' => MovieListResource::collection($futureMovies),
        ]);
    }

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
