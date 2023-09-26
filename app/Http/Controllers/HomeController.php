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
        $movieWithBanner = Movie::query()->hasBanner()->inRandomOrder()->with(['banner', 'genres'])->first();
        $selectedColumns = ['id', 'title', 'slug', 'thumbnail', 'age_restriction', 'director', 'start_showing', 'end_showing'];

        //TODO add caching of the movies and future movies
        $movies = Movie::currentlyScreeningWithGenres()->orderByDesc('priority')->take(self::ROW_LENGTH)->get($selectedColumns);
        $futureMovies = Movie::screeningSoonWithGenres()->orderBy('start_showing')->take(self::ROW_LENGTH / 2)->get($selectedColumns);

        $banner = $movieWithBanner ? MovieBannerResource::make($movieWithBanner)->resolve() : null;

        return Inertia::render('Home', [
            'banner' => $banner,
            'movies' => MovieListResource::collection($movies)->resolve(),
            'futureMovies' => MovieListResource::collection($futureMovies)->resolve(),
        ]);
    }
}
