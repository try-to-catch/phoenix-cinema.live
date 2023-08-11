<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieBanner;
use Database\Seeders\GenreSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_functions_properly(): void
    {
        $this->withoutExceptionHandling();
        $this->seed(GenreSeeder::class);
        $genres = Genre::take(3)->pluck('id')->toArray();

        $movie = Movie::factory()
            ->has(MovieBanner::factory(), 'banner')
            ->create(['start_showing' => now()->subDay(), 'end_showing' => now()->addMonth()]);
        $movie->genres()->attach($genres);

        $futureMovie = Movie::factory()
            ->create(['start_showing' => now()->addDay(), 'end_showing' => now()->addMonth()]);
        $futureMovie->genres()->attach($genres);

        $this->get('/')->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Home')
                ->has('banner', fn(Assert $page) => $page
                    ->whereAll([
                        'id' => $movie->id,
                        'title' => $movie->title,
                        'slug' => $movie->slug,
                        'start_showing' => $movie->start_showing->isoFormat('D MMMM'),
                        'end_showing' => $movie->end_showing->isoFormat('D MMMM'),
                        'duration' => $movie->formattedDuration,
                        'main_cast' => $movie->main_cast,
                        'production_country' => $movie->production_country,
                        'image' => $movie->banner->image_path,
                        'description' => $movie->banner->description,
                        'fact' => $movie->banner->fact,
                    ])
                    ->has('genres', $movie->genres->count(), fn(Assert $page) => $page
                        ->hasAll(['id', 'name'])
                    )
                )
                ->has('movies', 1, fn(Assert $page) => $page
                    ->whereAll([
                        'id' => $movie->id,
                        'title' => $movie->title,
                        'slug' => $movie->slug,
                        'thumbnail' => $movie->thumbnail_path,
                        'age_restriction' => $movie->age_restriction,
                        'director' => $movie->director,
                        'start_showing' => $movie->start_showing->isoFormat('D MMMM'),
                        'end_showing' => $movie->end_showing->isoFormat('D MMMM'),
                    ])
                    ->has('genres', $movie->genres->count(), fn(Assert $page) => $page
                        ->hasAll(['id', 'name'])
                    )
                )
                ->has('future_movies', 1, fn(Assert $page) => $page
                    ->whereAll([
                        'id' => $futureMovie->id,
                        'title' => $futureMovie->title,
                        'slug' => $futureMovie->slug,
                        'thumbnail' => $futureMovie->thumbnail_path,
                        'age_restriction' => $futureMovie->age_restriction,
                        'director' => $futureMovie->director,
                        'start_showing' => $futureMovie->start_showing->isoFormat('D MMMM'),
                        'end_showing' => $futureMovie->end_showing->isoFormat('D MMMM'),
                    ])
                    ->has('genres', $futureMovie->genres->count(), fn(Assert $page) => $page
                        ->hasAll(['id', 'name'])
                    )
                )
            );
    }
}
