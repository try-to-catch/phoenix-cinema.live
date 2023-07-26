<?php

namespace Tests\Feature\Admin;

use App\Actions\Seat\StoreSeatsAction;
use App\Models\Hall;
use App\Models\Role;
use App\Models\Seat;
use App\Models\User;
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
        ];
    }


    private function getSeatsSchema(): array
    {
        return [
            [
                ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard']
            ],
            [
                ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'], ['type' => 'standard'],
            ],
            [
                ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium'], ['type' => 'premium'],
            ]
        ];
    }


    public function test_hall_list_view_functions_properly()
    {
        $this->withoutExceptionHandling();

        $hall = Hall::factory()->create(['is_preset' => true]);

        $this->actingAs($this->admin)->get('/admin/halls')
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
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Halls/Create')
                ->whereContains('seat_types', Seat::SEAT_TYPES)
            );
    }


    public function test_hall_can_be_stored_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin)->post('/admin/halls', [...$this->getNewHall(), 'seats' => $this->getSeatsSchema()])
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

        $hall = Hall::factory()->create();

        $this->actingAs($this->admin)->get('/admin/halls/' . $hall->id)
            ->assertRedirect('/admin/halls/' . $hall->id . '/edit');
    }


    public function test_hall_edit_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();
        $storeSeats = new StoreSeatsAction();

        $hall = Hall::factory()->create();
        $storeSeats->handle($hall, $this->getSeatsSchema());

        $this->actingAs($this->admin)->get('/admin/halls/' . $hall->id . '/edit')
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/Halls/Edit')
                ->has('hall', fn(Assert $page) => $page
                    ->has('data', fn(Assert $page) => $page
                        ->where('id', $hall->id)
                        ->where('title', $hall->title)
                        ->has('seats', fn(Assert $page) => $page
                            ->count(count($this->getSeatsSchema()))
                            ->has('0.0.id')
                            ->has('0.0.type')
                            ->has('0.0.row_number')
                            ->has('0.0.seat_number')
                            ->etc()
                        )
                        ->etc()
                    )
                )
            );
    }
}
