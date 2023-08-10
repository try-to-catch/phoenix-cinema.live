<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Genre;
use App\Models\HallTemplate;
use App\Models\Movie;
use App\Models\MovieBanner;
use App\Models\Screening;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $this->call([GenreSeeder::class, RoleSeeder::class]);

            Genre::query()->inRandomOrder()->take(10)->get()
                ->each(function (Genre $genre) {
                    $genre->movies()->saveMany(Movie::factory()->count(10)->make());
                });

            Movie::all()->each(function (Movie $movie) {
                $movie->screenings()->saveMany(Screening::factory()->count(30)->make());
            });

            HallTemplate::factory(3)->create();

            MovieBanner::factory(7)->create();

        });
    }
}
