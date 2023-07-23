<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Images\StoreThumbnailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Movie\StoreMovieRequest;
use App\Http\Resources\Admin\Genre\GenreResource;
use App\Http\Resources\Admin\Movie\MovieItemResource;
use App\Http\Resources\Admin\Movie\MovieListResource;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MovieController extends Controller
{


    public function __construct(public StoreThumbnailAction $storeThumbnailAction)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $movies = Movie::select([
            'id',
            'title',
            'slug',
            'duration_in_minutes',
            'age_restriction',
            'thumbnail',
            'start_showing',
            'end_showing',
        ])->paginate();

        return Inertia::render('Admin/Movies/Index', [
            'movies' => MovieListResource::collection($movies),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Movies/Create', [
            'genres' => GenreResource::collection(Genre::all('id', 'name'))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request): RedirectResponse
    {
        $newMovie = $request->validated();
        $newMovie['thumbnail'] = $this->storeThumbnailAction->handle($newMovie['thumbnail'], 'movie');

        $movie = tap(
            Movie::create($newMovie),
            fn(Movie $movie) => $movie->genres()->attach($newMovie['genres'])
        );

        return to_route('admin.movies.show', ['movie' => $movie->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): Response
    {
        $movie->load('genres');
        return Inertia::render('Admin/Movies/Show', [
            'movie' => new MovieItemResource($movie),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
