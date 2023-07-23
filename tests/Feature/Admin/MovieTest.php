<?php

namespace Tests\Feature\Admin;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\GenreSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, GenreSeeder::class]);

        $adminId = Role::whereAdmin()->pluck('id');
        $this->user = User::factory()->create();

        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($adminId);
    }


    public function createThumbnail(): File
    {
        return File::image('thumbnail.jpg', 320, 472);
    }


    public function getRandomGenreIDs(int $number = 4): array
    {
        return Genre::query()->inRandomOrder()->take($number)->pluck('id')->toArray();
    }


    public function getNewMovie(): array
    {
        return [
            'title' => 'Test Movie',
            'description' => 'Test Description',
            'priority' => 2,
            'duration_in_minutes' => 120,
            'age_restriction' => '16+',
            'thumbnail' => $this->createThumbnail(),
            'release_year' => '2021',
            'original_title' => 'Test Original Title',
            'production_country' => 'Test Production Country',
            'studio' => 'Test Studio',
            'main_cast' => 'Test Main Cast',
            'start_showing' => '2021-10-10',
            'end_showing' => '2021-10-20',
            'genres' => $this->getRandomGenreIDs(),
        ];
    }


    public function test_movie_list_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $movie = Movie::factory()->create();

        $this->actingAs($this->admin)->get('/admin/movies')
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Movies/Index')
                ->has('movies', fn(Assert $page) => $page
                    ->has('data', 1, fn(Assert $page) => $page
                        ->where('id', $movie->id)
                        ->where('title', $movie->title)
                        ->where('slug', $movie->slug)
                        ->where('duration_in_minutes', $movie->duration_in_minutes)
                        ->where('age_restriction', $movie->age_restriction)
                        ->where('thumbnail', $movie->thumbnail)
                        ->where('start_showing', $movie->start_showing->format('d-m-Y'))
                        ->where('end_showing', $movie->end_showing->format('d-m-Y'))
                        ->etc()
                    )->etc()
                )
            );
    }


    public function test_non_admin_user_cannot_access_movie_list_view(): void
    {
        $this->actingAs($this->user)->get('/admin/movies')
            ->assertStatus(403);
    }


    public function test_movie_create_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin)->get('/admin/movies/create')
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Movies/Create')
                ->has('genres', 1, fn(Assert $page) => $page
                    ->count(Genre::count())
                    ->has('0.id')
                    ->has('0.name')
                    ->etc()
                )
            );
    }


    public function test_non_admin_user_cannot_access_movie_create_view(): void
    {
        $this->actingAs($this->user)->get('/admin/movies/create')
            ->assertStatus(403);
    }


    public function test_movie_can_be_stored_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin)
            ->post('/admin/movies', $this->getNewMovie())
            ->assertRedirect('/admin/movies/test-movie');

        $this->assertDatabaseCount('movies', 1)
            ->assertDatabaseHas('movies', [
                'title' => 'Test Movie',
                'slug' => 'test-movie',
                'description' => 'Test Description',
                'priority' => 2,
                'duration_in_minutes' => 120,
                'age_restriction' => '16+',
                'release_year' => '2021',
                'original_title' => 'Test Original Title',
                'production_country' => 'Test Production Country',
                'studio' => 'Test Studio',
                'main_cast' => 'Test Main Cast',
                'start_showing' => '2021-10-10 00:00:00',
                'end_showing' => '2021-10-20 00:00:00',
            ]);

        $movie = Movie::query()->first('thumbnail');

        $this->assertFileExists(storage_path("app/public/$movie->thumbnail"));
    }


    public function test_non_admin_user_cannot_store_movie(): void
    {
        $this->actingAs($this->user)
            ->post('/admin/movies', $this->getNewMovie())
            ->assertStatus(403);
    }


    public function test_movie_cannot_be_stored_with_invalid_data(): void
    {
        $newMovie = $this->getNewMovie();

        $newMovie['title'] = '';
        $newMovie['thumbnail'] = '';

        $this->actingAs($this->admin)
            ->post('/admin/movies', $newMovie)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'title',
                'thumbnail',
            ]);
    }


    public function test_movie_show_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $movie = Movie::factory()->create();
        $movie->genres()->attach($this->getRandomGenreIDs());

        $this->actingAs($this->admin)->get('/admin/movies/' . $movie->slug)
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Movies/Show')
                ->has('movie', fn(Assert $page) => $page
                    ->has('data', fn(Assert $page) => $page
                        ->where('id', $movie->id)
                        ->where('title', $movie->title)
                        ->where('slug', $movie->slug)
                        ->where('description', $movie->description)
                        ->where('duration_in_minutes', $movie->duration_in_minutes)
                        ->where('age_restriction', $movie->age_restriction)
                        ->where('thumbnail', $movie->thumbnail)
                        ->where('release_year', $movie->release_year)
                        ->where('production_country', $movie->production_country)
                        ->where('studio', $movie->studio)
                        ->where('main_cast', $movie->main_cast)
                        ->where('start_showing', $movie->start_showing->format('d-m-Y'))
                        ->where('end_showing', $movie->end_showing->format('d-m-Y'))
                        ->has('genres', fn(Assert $page) => $page
                            ->count($movie->genres->count())
                            ->has('0.id')
                            ->has('0.name')
                            ->etc()
                        )
                        ->etc()
                    )
                )
            );
    }
}
