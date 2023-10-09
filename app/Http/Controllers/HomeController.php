<?php

namespace App\Http\Controllers;

use App\Actions\Movies\GetCurrentScreeningMoviesAction;
use App\Actions\Movies\GetFutureMoviesAction;
use App\Actions\Movies\GetMovieWithBannerResolvedAction;
use App\Http\Resources\Movie\MovieListResource;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    protected const ROW_LENGTH = 12;

    public function __invoke(
        GetCurrentScreeningMoviesAction  $getMoviesAction,
        GetFutureMoviesAction            $getFutureMoviesAction,
        GetMovieWithBannerResolvedAction $getMovieWithBannerAction
    ): Response
    {
        $selectedColumns = ['id', 'title', 'slug', 'thumbnail', 'age_restriction', 'director', 'start_showing', 'end_showing'];

        $movies = $getMoviesAction->handle($selectedColumns, self::ROW_LENGTH);
        $futureMovies = $getFutureMoviesAction->handle($selectedColumns, self::ROW_LENGTH / 2);

        return Inertia::render('Home', [
            'banner' => $getMovieWithBannerAction->handle(),
            'movies' => MovieListResource::collection($movies)->resolve(),
            'futureMovies' => MovieListResource::collection($futureMovies)->resolve(),
        ]);
    }
}
