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

        $adminId = Role::admin()->pluck('id');
        $this->user = User::factory()->create();

        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($adminId);
    }

    public function test_movie_list_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin)->get('/admin/screenings')
            ->assertRedirectToRoute('admin.movies.screenings.index');
    }

    private function createScreening($withHall = false)
    {
        return tap(
            Screening::factory()->create(),
            fn (Screening $screening) => $withHall
                ? Hall::factory()->create(['screening_id' => $screening->id])
                : null
        );
    }

    public function test_screening_create_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();
        $hallTemplate = HallTemplate::factory()->create();

        $this->actingAs($this->admin)->get('/admin/screenings/create')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Screenings/Create')
                ->has('movies', 1, fn (Assert $page) => $page
                    ->whereAll([
                        'id' => $this->movie->id,
                        'title' => $this->movie->title,
                    ])
                )
                ->has('hallTemplates', 1, fn (Assert $page) => $page
                    ->whereAll([
                        'id' => $hallTemplate->id,
                        'address' => $hallTemplate->address,
                        'number' => $hallTemplate->number,
                    ])
                )
            );
    }

    public function test_screening_can_be_stored_by_admin()
    {
        $this->withoutExceptionHandling();

        $newScreening = $this->getNewScreening(HallTemplate::factory()->create()->id);

        $this->actingAs($this->admin)
            ->post('/admin/screenings', $newScreening)
            ->assertRedirect('/admin/screenings/'.Screening::first()->id);

        $this->assertDatabaseCount('screenings', 1)
            ->assertDatabaseHas('screenings', [
                'movie_id' => $this->movie->id,
                'standard_seat_price_in_cents' => $newScreening['standard_seat_price'] * 100,
                'premium_seat_price_in_cents' => $newScreening['premium_seat_price'] * 100,
            ]);
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

    public function test_screenings_cannot_be_stored_with_invalid_data()
    {
        $errorKeys = array_keys($this->getNewScreening(HallTemplate::factory()->create()->id), ['end_time' => '']);
        unset($errorKeys['end_time']);

        $this->actingAs($this->admin)
            ->post('/admin/screenings', [
                'movie_id' => '1',
                'start_time' => '2021-05-05 35:00',
            ])
            ->assertSessionHasErrors($errorKeys);
    }

    public function test_show_returns_redirect_to_edit_page(): void
    {
        $this->withoutExceptionHandling();

        $screening = $this->createScreening();

        $this->actingAs($this->admin)->get('/admin/screenings/'.$screening->id)
            ->assertRedirect('/admin/screenings/'.$screening->id.'/edit');
    }

    public function test_screening_edit_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $screening = $this->createScreening(true);

        $this->actingAs($this->admin)->get('/admin/screenings/'.$screening->id.'/edit')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Admin/Screenings/Edit')
                ->has('screening', fn (Assert $page) => $page
                    ->whereAll([
                        'id' => $screening->id,
                        'start_time' => $screening->start_time->format('Y-m-d H:i'),
                        'end_time' => $screening->end_time->format('Y-m-d H:i'),
                        'standard_seat_price' => $screening->standard_seat_price,
                        'premium_seat_price' => $screening->premium_seat_price,
                    ])
                    ->has('movie', fn (Assert $page) => $page
                        ->whereAll([
                            'id' => $screening->movie->id,
                            'title' => $screening->movie->title,
                        ])
                    )
                    ->has('hall', fn (Assert $page) => $page
                        ->whereAll([
                            'id' => $screening->hall->id,
                            'address' => $screening->hall->address,
                            'number' => $screening->hall->number,
                        ])
                    )
                )
            );
    }

    public function test_screening_can_be_updated_by_admin()
    {
        $this->withoutExceptionHandling();

        $screening = $this->createScreening();
        $screening->start_time = $screening->start_time->addHour();
        $screening->end_time = $screening->end_time->addHours(2);
        $screening->standard_seat_price += 20;

        $this->actingAs($this->admin)
            ->put('/admin/screenings/'.$screening->id, $screening->toArray())
            ->assertRedirect('/admin/screenings/'.$screening->id);

        $this->assertDatabaseCount('screenings', 1)
            ->assertDatabaseHas('screenings', [
                'id' => $screening->id,
                'start_time' => $screening->start_time->format('Y-m-d H:i'),
                'premium_seat_price_in_cents' => $screening->premium_seat_price * 100,
            ]);
    }

    public function test_screening_cannot_be_updated_with_invalid_data(): void
    {
        $screening = Screening::factory()->create();

        $this->actingAs($this->admin)
            ->put('/admin/screenings/'.$screening->id, [
                'start_time' => '2021-05-05 35:00',
                'standard_seat_price' => null,
            ])
            ->assertSessionHasErrors(['start_time', 'standard_seat_price']);
    }

    public function test_screening_can_be_deleted_by_admin()
    {
        $this->withoutExceptionHandling();

        $screening = $this->createScreening(true);

        $this->assertDatabaseCount('screenings', 1);

        $this->actingAs($this->admin)
            ->delete('/admin/screenings/'.$screening->id)
            ->assertRedirect('/admin/movies/screenings');

        $this->assertDatabaseCount('screenings', 0);
    }

    public function test_screening_with_reservations_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $screening = $this->createScreening(true);
        $seat = $screening->seats()->first();
        $seat->update(['order_id' => $screening->orders()->create()->id]);

        $this->assertDatabaseCount('screenings', 1);

        $this->actingAs($this->admin)
            ->delete('/admin/screenings/'.$screening->id)
            ->assertRedirectToRoute('admin.movies.screenings.index')
            ->assertSessionHas('message', [
                'type' => 'success',
                'text' => 'Сеанс успішно видалено.',
            ]);

        $this->assertDatabaseCount('screenings', 0);
    }

    public function test_non_admin_user_cannot_access_to_screening(): void
    {
        $screening = Screening::factory()->create();

        $this->actingAs($this->user)
            ->post('/admin/screenings')
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->put('/admin/screenings/'.$screening->id)
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->delete('/admin/screenings/'.$screening->id)
            ->assertStatus(403);
    }
}
