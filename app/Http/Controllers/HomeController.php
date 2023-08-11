<?php

namespace App\Http\Controllers;

use App\Http\Resources\Movie\MovieListResource;
use App\Http\Resources\MovieBanner\MovieBannerResource;
use App\Models\Movie;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{

    protected const ROW_LENGTH = 12;

    public function __invoke(): Response
    {
        $movieWithBanner = Movie::hasBanner()->inRandomOrder()->with(['banner', 'genres'])->first();
        $selectedColumns = ['id', 'title', 'slug', 'thumbnail', 'age_restriction', 'director', 'start_showing', 'end_showing'];

        //TODO add caching of the movies and future movies
        $movies = Movie::currentlyScreeningWithGenres()->orderByDesc('priority')->take(self::ROW_LENGTH)->get($selectedColumns);
        $futureMovies = Movie::screeningSoonWithGenres()->orderBy('start_showing')->take(self::ROW_LENGTH)->get($selectedColumns);

        return Inertia::render('Home', [
            'banner' => MovieBannerResource::make($movieWithBanner)->resolve(),
            'movies' => MovieListResource::collection($movies)->resolve(),
            'future_movies' => MovieListResource::collection($futureMovies)->resolve(),
        ]);
    }
}
