<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Genre;
use App\Models\HallTemplate;
use App\Models\Movie;
use App\Models\MovieBanner;
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

            Genre::query()->inRandomOrder()->take(10)
                ->each(function (Genre $genre) {
                    $genre->movies()->saveMany(Movie::factory()->count(2)->make());
                });

            HallTemplate::factory(3)->create();

            Movie::factory(10)->create();
            MovieBanner::factory(3)->create();

        });
    }
}
