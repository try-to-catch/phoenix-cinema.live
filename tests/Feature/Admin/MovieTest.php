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

        $adminId = Role::admin()->pluck('id');
        $this->user = User::factory()->create();

        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($adminId);
    }

    private function createThumbnail(): File
    {
        return File::image('thumbnail.jpg', 320, 472);
    }

    private function getRandomGenreIDs(int $number = 4): array
    {
        return Genre::query()->inRandomOrder()->take($number)->pluck('id')->toArray();
    }

    private function getNewMovie(): array
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
            'director' => '	Steven Spielberg',
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
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Movies/Index')
                ->has('movies', fn (Assert $page) => $page
                    ->has('data', 1, fn (Assert $page) => $page
                        ->whereAll([
                            'id' => $movie->id,
                            'title' => $movie->title,
                            'slug' => $movie->slug,
                            'director' => $movie->director,
                            'age_restriction' => $movie->age_restriction,
                            'thumbnail' => $movie->thumbnail_path,
                            'start_showing' => $movie->start_showing->isoFormat('D MMMM'),
                            'end_showing' => $movie->end_showing->isoFormat('D MMMM'),
                        ])
                        ->has('genres')
                    )
                    ->hasAll(['links', 'meta'])
                )
            );
    }

    public function test_movie_create_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin)->get('/admin/movies/create')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Movies/Create')
                ->has('genres', Genre::count(), fn (Assert $page) => $page
                    ->hasAll(['id', 'name'])
                )
            );
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

    public function test_movie_cannot_be_stored_with_invalid_data(): void
    {
        $newMovie = $this->getNewMovie();

        $newMovie['title'] = '';
        $newMovie['thumbnail'] = '';

        $this->actingAs($this->admin)
            ->post('/admin/movies', $newMovie)
            ->assertStatus(302)
            ->assertSessionHasErrors(['title', 'thumbnail']);
    }

    public function test_movie_show_returns_redirect_to_movies_edit(): void
    {
        $this->withoutExceptionHandling();

        $movie = Movie::factory()->create();

        $this->actingAs($this->admin)->get('/admin/movies/'.$movie->slug)
            ->assertRedirect('/admin/movies/'.$movie->slug.'/edit');
    }

    public function test_movie_edit_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $movie = Movie::factory()->create();
        $movie->genres()->attach($this->getRandomGenreIDs());

        $this->actingAs($this->admin)->get('/admin/movies/'.$movie->slug.'/edit')
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Movies/Edit')
                ->has('movie', fn (Assert $page) => $page
                    ->whereAll([
                        'id' => $movie->id,
                        'title' => $movie->title,
                        'slug' => $movie->slug,
                        'description' => $movie->description,
                        'priority' => $movie->priority,
                        'director' => $movie->director,
                        'duration_in_minutes' => $movie->duration_in_minutes,
                        'age_restriction' => $movie->age_restriction,
                        'thumbnail' => $movie->thumbnail_path,
                        'release_year' => $movie->release_year,
                        'original_title' => $movie->original_title,
                        'production_country' => $movie->production_country,
                        'studio' => $movie->studio,
                        'main_cast' => $movie->main_cast,
                        'start_showing' => $movie->start_showing->format('Y-m-d'),
                        'end_showing' => $movie->end_showing->format('Y-m-d'),
                    ])
                    ->has('genres')
                    ->has('banner')
                )
                ->has('genres', Genre::count(), fn (Assert $page) => $page
                    ->hasAll(['id', 'name'])
                )
            );
    }

    public function test_movie_can_be_updated_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $movie = Movie::factory()->create();
        $movie->genres()->attach($this->getRandomGenreIDs());

        $this->actingAs($this->admin)
            ->put('/admin/movies/'.$movie->slug, $this->getNewMovie())
            ->assertRedirect('/admin/movies/'.$movie->slug);

        $this->assertDatabaseCount('movies', 1)
            ->assertDatabaseHas('movies', [
                'title' => 'Test Movie',
                'slug' => $movie->slug,
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

        $updatedMovie = Movie::query()->first('thumbnail');
        $this->assertFileExists(storage_path("app/public/$updatedMovie->thumbnail"));
        $this->assertFileDoesNotExist(storage_path("app/public/$movie->thumbnail"));
    }

    public function test_movie_cannot_be_updated_with_invalid_data(): void
    {
        $movie = Movie::factory()->create();

        $newMovie = $this->getNewMovie();

        $newMovie['title'] = '';
        $newMovie['thumbnail'] = 'string is not a file';

        $this->actingAs($this->admin)
            ->put('/admin/movies/'.$movie->slug, $newMovie)
            ->assertStatus(302)
            ->assertSessionHasErrors(['title', 'thumbnail']);
    }

    public function test_movie_can_be_deleted_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $movie = Movie::factory()->create();

        $this->actingAs($this->admin)
            ->delete('/admin/movies/'.$movie->slug)
            ->assertRedirect('/admin/movies');

        $this->assertDatabaseCount('movies', 0);

        $this->assertFileDoesNotExist(storage_path("app/public/$movie->thumbnail"));
    }

    public function test_non_admin_user_cannot_access_to_movies(): void
    {
        $movie = Movie::factory()->create();

        $this->actingAs($this->user)
            ->post('/admin/movies')
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->put('/admin/movies/'.$movie->slug)
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->delete('/admin/movies/'.$movie->slug)
            ->assertStatus(403);
    }
}
