<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Screening;
use Database\Seeders\GenreSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function test_movie_show_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $this->seed(GenreSeeder::class);
        $genres = Genre::take(3)->pluck('id')->toArray();

        $movie = Movie::factory()->has(Screening::factory())->create();
        $movie->genres()->attach($genres);

        $this->get('/movies/'.$movie->slug)->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Movies/Show')
                ->has('movie', fn (Assert $page) => $page
                    ->whereAll([
                        'id' => $movie->id,
                        'title' => $movie->title,
                        'slug' => $movie->slug,
                        'description' => $movie->description,
                        'duration' => $movie->formatted_duration,
                        'age_restriction' => $movie->age_restriction,
                        'thumbnail' => $movie->thumbnail_path,
                        'release_year' => $movie->release_year,
                        'original_title' => $movie->original_title,
                        'director' => $movie->director,
                        'production_country' => $movie->production_country,
                        'studio' => $movie->studio,
                        'main_cast' => $movie->main_cast,
                        'start_showing' => $movie->start_showing->isoFormat('D MMMM'),
                        'end_showing' => $movie->end_showing->isoFormat('D MMMM'),
                    ])
                    ->has('genres', $movie->genres->count(), fn (Assert $page) => $page
                        ->hasAll(['id', 'name', 'slug'])
                    )
                )
                ->has('screenings', 1, fn (Assert $page) => $page
                    ->has('date')
                    ->has('screenings', 1, fn (Assert $page) => $page
                        ->hasAll(['id', 'time'])
                    )
                )
            );
    }
}
