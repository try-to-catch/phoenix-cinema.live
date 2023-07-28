<?php

namespace Tests\Feature\Admin;

use App\Models\Hall;
use App\Models\Role;
use App\Models\Seat;
use App\Models\User;
use Database\Seeders\HallWithSeatsSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HallTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);

        $adminId = Role::whereAdmin()->pluck('id');
        $this->user = User::factory()->create();

        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($adminId);
    }


    private function getNewHall(): array
    {
        return [
            'title' => 'Test Hall',
            'is_available' => true,
            'is_preset' => true,
            'seats' => [
                [
                    ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard']
                ],
                [
                    ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'],
                ],
                [
                    ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium'],
                ]
            ]
        ];
    }


    public function test_hall_list_view_functions_properly()
    {
        $this->withoutExceptionHandling();

        $hall = Hall::factory()->create(['is_preset' => true]);

        $this->actingAs($this->admin)->get('/admin/halls')
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Halls/Index')
                ->has('halls', fn(Assert $page) => $page
                    ->has('data', 1, fn(Assert $page) => $page
                        ->where('id', $hall->id)
                        ->where('title', $hall->title)
                        ->where('is_available', $hall->is_available)
                        ->where('seats_count', $hall->seats()->count())
                    )->etc()
                )
            );
    }


    public function test_hall_create_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin)->get('/admin/halls/create')
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Halls/Create')
                ->whereContains('seat_types', Seat::SEAT_TYPES)
            );
    }


    public function test_hall_can_be_stored_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin)->post('/admin/halls', $this->getNewHall())
            ->assertRedirect('/admin/halls/' . Hall::first()->id);

        $this->assertDatabaseHas('halls', [
            'title' => 'Test Hall',
            'is_available' => true,
        ]);
    }


    public function test_movie_cannot_be_stored_with_invalid_data(): void
    {
        $newHall = $this->getNewHall();

        $newHall['title'] = '';
        $newHall['seats'] = ['standard', 'premium'];

        $this->actingAs($this->admin)
            ->post('/admin/halls', $newHall)
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'title',
                'seats.*'
            ]);
    }


    public function test_edit_show_returns_redirect_to_halls_edit(): void
    {
        $this->withoutExceptionHandling();

        $hall = Hall::factory()->create(['is_preset' => true]);

        $this->actingAs($this->admin)->get('/admin/halls/' . $hall->id)
            ->assertRedirect('/admin/halls/' . $hall->id . '/edit');
    }


    public function test_hall_edit_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $this->seed(HallWithSeatsSeeder::class);

        $hall = Hall::first();

        $this->actingAs($this->admin)->get('/admin/halls/' . $hall->id . '/edit')
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Halls/Edit')
                ->has('hall', fn(Assert $page) => $page
                    ->has('data', fn(Assert $page) => $page
                        ->where('id', $hall->id)
                        ->where('title', $hall->title)
                        ->where('is_available', $hall->is_available)
                        ->has('seats', fn(Assert $page) => $page
                            ->count(count($this->getNewHall()['seats']))
                            ->has('0.0.id')
                            ->has('0.0.type')
                            ->has('0.0.row_number')
                            ->has('0.0.seat_number')
                            ->etc()
                        )
                    )
                )
            );
    }


    public function test_hall_can_be_updated_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $this->seed(HallWithSeatsSeeder::class);

        $hall = Hall::query()
            ->with(['seats' => fn($query) => $query->inRandomOrder()->take(1)->get()])
            ->first();

        $hall->seats[0]->type = $hall->seats[0]->type !== 'premium' ? 'premium' : 'standard';

        $this->actingAs($this->admin)
            ->patch('/admin/halls/' . $hall->id, [...$this->getNewHall(), 'updated_seats' => $hall->seats->toArray()])
            ->assertRedirect('/admin/halls/' . $hall->id);

        $this->assertDatabaseHas('halls', [
            'title' => 'Test Hall',
            'is_available' => true,
        ]);

        $this->assertDatabaseHas('seats', $hall->seats[0]->only(['id', 'type', 'row_number', 'seat_number']));
    }


    public function test_hall_cannot_be_updated_with_invalid_data(): void
    {
        $this->seed(HallWithSeatsSeeder::class);

        $hall = Hall::query()
            ->with(['seats' => fn($query) => $query->inRandomOrder()->take(1)->get()])
            ->first(['id', 'title', 'is_available']);

        $hall->title = ''; //Title cannot be empty
        $hall->seats[0]->type = 'VIP'; //There is no such a type

        $this->actingAs($this->admin)
            ->patch('/admin/halls/' . $hall->id, [...$hall->toArray(), 'updated_seats' => $hall->seats->toArray()])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'title',
                'updated_seats.*.type'
            ]);
    }


    public function test_hall_can_be_deleted_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $this->seed(HallWithSeatsSeeder::class);

        $hall = Hall::first();

        $this->actingAs($this->admin)->delete('/admin/halls/' . $hall->id)
            ->assertRedirect('/admin/halls');

        $this->assertDatabaseMissing('halls', ['id' => $hall->id]);
        $this->assertDatabaseMissing('seats', ['hall_id' => $hall->id]);
    }


    public function test_non_admin_user_cannot_access_to_movies(): void
    {
        $hall = Hall::factory()->create(['is_preset' => true]);

        $this->actingAs($this->user)
            ->post('/admin/halls')
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->put('/admin/halls/' . $hall->id)
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->delete('/admin/halls/' . $hall->id)
            ->assertStatus(403);
    }


    public function test_preset_hall_cannot_be_deleted_updated(): void
    {
        $hall = Hall::factory()->create(['is_preset' => false]);

        $this->actingAs($this->admin)->delete('/admin/halls/' . $hall->id)
            ->assertStatus(403);

        $this->actingAs($this->admin)->patch('/admin/halls/' . $hall->id, $hall->toArray())
            ->assertStatus(403);
    }
}
