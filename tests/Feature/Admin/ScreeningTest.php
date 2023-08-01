<?php

namespace Admin;

use App\Models\Hall;
use App\Models\HallTemplate;
use App\Models\Movie;
use App\Models\Role;
use App\Models\Screening;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ScreeningTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->movie = Movie::factory()->create(['end_showing' => now()->addDays()]);
        $this->hall = Hall::factory()->create();

        $adminId = Role::admin()->pluck('id');
        $this->user = User::factory()->create();

        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($adminId);
    }


    private function getNewScreening(string $hallTemplateId): array
    {
        return [
            'movie_id' => $this->movie->id,
            'hall_template_id' => $hallTemplateId,
            'start_time' => now()->addDays()->format('Y-m-d\TH:i'),
            'end_time' => now()->addDays()->addHours(2)->format('Y-m-d\TH:i'),
            'standard_seat_price' => 150,
            'premium_seat_price' => 200,
        ];
    }


    private function createScreening()
    {
        return Screening::factory()->create([
            'movie_id' => $this->movie->id,
            'hall_id' => $this->hall->id,
        ]);
    }


    public function test_movie_list_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $screening = $this->createScreening();

        $this->actingAs($this->admin)->get('/admin/screenings')
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Screenings/Index')
                ->has('screenings.data', 1, fn(Assert $page) => $page
                    ->where('id', $screening->id)
                    ->where('start_time', $screening->start_time->format('Y-m-d H:i'))
                    ->where('end_time', $screening->end_time->format('Y-m-d H:i'))
                    ->has('movie', fn(Assert $page) => $page
                        ->where('id', $screening->movie->id)
                        ->where('slug', $screening->movie->slug)
                        ->where('title', $screening->movie->title)
                        ->where('thumbnail', $screening->movie->thumbnail_path)
                        ->where('duration_in_minutes', $screening->movie->duration_in_minutes)
                    )
                    ->has('hall', fn(Assert $page) => $page
                        ->where('id', $screening->hall->id)
                        ->where('title', $screening->hall->title)
                    )
                )
            );
    }


    public function test_screening_create_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();
        $hallTemplate = HallTemplate::factory()->create();

        $this->actingAs($this->admin)->get('/admin/screenings/create')
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Screenings/Create')
                ->has('movies', 1, fn(Assert $page) => $page
                    ->where('0.id', $this->movie->id)
                    ->where('0.title', $this->movie->title)
                    ->etc()
                )
                ->has('hall_templates', 1, fn(Assert $page) => $page
                    ->where('0.id', $hallTemplate->id)
                    ->where('0.title', $hallTemplate->title)
                    ->etc()
                )
            );
    }


    public function test_screening_can_be_stored_by_admin()
    {
        $this->withoutExceptionHandling();

        $newScreening = $this->getNewScreening(HallTemplate::factory()->create()->id);

        $this->actingAs($this->admin)
            ->post('/admin/screenings', $newScreening)
            ->assertRedirect('/admin/screenings/' . Screening::first()->id);

        $this->assertDatabaseCount('screenings', 1)
            ->assertDatabaseHas('screenings', [
                'movie_id' => $this->movie->id,
                'standard_seat_price_in_cents' => $newScreening['standard_seat_price'] * 100,
                'premium_seat_price_in_cents' => $newScreening['premium_seat_price'] * 100,
            ]);
    }


    public function test_screenings_cannot_be_stored_with_invalid_data()
    {
        $this->actingAs($this->admin)
            ->post('/admin/screenings', [
                'movie_id' => '1',
                'start_time' => '2021-05-05 35:00',
            ])
            ->assertSessionHasErrors(array_keys($this->getNewScreening(HallTemplate::factory()->create()->id)));
    }


    public function test_show_returns_redirect_to_edit_page(): void
    {
        $this->withoutExceptionHandling();

        $screening = $this->createScreening();

        $this->actingAs($this->admin)->get('/admin/screenings/' . $screening->id)
            ->assertRedirect('/admin/screenings/' . $screening->id . '/edit');
    }


    public function test_screening_edit_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $screening = $this->createScreening();

        $this->actingAs($this->admin)->get('/admin/screenings/' . $screening->id . '/edit')
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Screenings/Edit')
                ->has('screening', 1, fn(Assert $page) => $page
                    ->where('id', $screening->id)
                    ->where('start_time', $screening->start_time->format('Y-m-d H:i'))
                    ->where('end_time', $screening->end_time->format('Y-m-d H:i'))
                    ->where('standard_seat_price', $screening->standard_seat_price_in_cents)
                    ->where('premium_seat_price', $screening->premium_seat_price_in_cents)
                    ->has('movie', fn(Assert $page) => $page
                        ->where('id', $screening->movie->id)
                        ->where('slug', $screening->movie->slug)
                        ->where('title', $screening->movie->title)
                        ->where('thumbnail', $screening->movie->thumbnail_path)
                        ->where('duration_in_minutes', $screening->movie->duration_in_minutes)
                    )
                    ->has('hall', fn(Assert $page) => $page
                        ->where('id', $screening->hall->id)
                        ->where('title', $screening->hall->title)
                    )
                )
            );
    }
}