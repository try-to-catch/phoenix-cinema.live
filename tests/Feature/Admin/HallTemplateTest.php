<?php

namespace Tests\Feature\Admin;

use App\Models\HallTemplate;
use App\Models\Role;
use App\Models\Seat;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HallTemplateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->user = User::factory()->create();

        $this->admin = User::factory()->create();
        $this->admin->roles()->attach(Role::admin()->pluck('id'));
    }


    private function getNewTemplate(): array
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


    private function getTemplateWithRandomSeat()
    {
        $template = HallTemplate::factory()->create();
        return $template->load(['seats' => fn($query) => $query->inRandomOrder()->take(1)->get()])
            ->first(['id', 'title', 'is_available']);
    }

    public function test_hall_list_view_functions_properly()
    {
        $this->withoutExceptionHandling();

        $template = HallTemplate::factory()->create();

        $this->actingAs($this->admin)->get('/admin/hall-templates')
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/HallTemplates/Index')
                ->has('hall_templates', fn(Assert $page) => $page
                    ->has('data', 1, fn(Assert $page) => $page
                        ->where('id', $template->id)
                        ->where('title', $template->title)
                        ->where('is_available', $template->is_available)
                        ->where('seats_count', $template->seats()->count())
                    )->etc()
                )
            );
    }


    public function test_hall_create_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin)->get('/admin/hall-templates/create')
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/HallTemplates/Create')
                ->whereContains('seat_types', Seat::SEAT_TYPES)
            );
    }


    public function test_hall_can_be_stored_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->admin)->post('/admin/hall-templates', $this->getNewTemplate())
            ->assertRedirect('/admin/hall-templates/' . HallTemplate::first()->id);

        $this->assertDatabaseHas('hall_templates', [
            'title' => 'Test Hall',
            'is_available' => true,
        ]);
    }


    public function test_movie_cannot_be_stored_with_invalid_data(): void
    {
        $newHall = $this->getNewTemplate();

        $newHall['title'] = '';
        $newHall['seats'] = ['standard', 'premium'];

        $this->actingAs($this->admin)
            ->post('/admin/hall-templates', $newHall)
            ->assertStatus(302)
            ->assertSessionHasErrors(['title', 'seats.*']);
    }


    public function test_show_returns_redirect_to_hall_templates_edit_page(): void
    {
        $this->withoutExceptionHandling();

        $template = HallTemplate::factory()->create();

        $this->actingAs($this->admin)->get('/admin/hall-templates/' . $template->id)
            ->assertRedirect('/admin/hall-templates/' . $template->id . '/edit');
    }


    public function test_hall_edit_view_functions_properly(): void
    {
        $this->withoutExceptionHandling();

        $template = HallTemplate::factory()->create();

        $this->actingAs($this->admin)->get('/admin/hall-templates/' . $template->id . '/edit')
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Admin/HallTemplates/Edit')
                ->has('hall_template', fn(Assert $page) => $page
                    ->where('id', $template->id)
                    ->where('title', $template->title)
                    ->where('is_available', $template->is_available)
                    ->has('seats', fn(Assert $page) => $page
                        ->count(count($this->getNewTemplate()['seats']))
                        ->has('0.0.id')
                        ->has('0.0.type')
                        ->has('0.0.row_number')
                        ->has('0.0.seat_number')
                        ->etc()
                    )
                )
            );
    }


    public function test_hall_can_be_updated_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $template = $this->getTemplateWithRandomSeat();

        $template->seats[0]->type = $template->seats[0]->type !== 'premium' ? 'premium' : 'standard';

        $this->actingAs($this->admin)
            ->patch('/admin/hall-templates/' . $template->id, [...$this->getNewTemplate(), 'updated_seats' => $template->seats->toArray()])
            ->assertRedirect('/admin/hall-templates/' . $template->id);

        $this->assertDatabaseHas('hall_templates', [
            'title' => 'Test Hall',
            'is_available' => true,
        ]);

        $seat = $template->seats[0]->only(['id', 'type', 'row_number', 'seat_number']);
        $seat['type'] = array_search($seat['type'], Seat::SEAT_TYPES);
        $this->assertDatabaseHas('seats', $seat);
    }


    public function test_hall_cannot_be_updated_with_invalid_data(): void
    {
        $template = $this->getTemplateWithRandomSeat();

        $template->title = ''; //Title cannot be empty
        $template->seats[0]->type = 'VIP'; //There is no such a type

        $this->actingAs($this->admin)
            ->patch('/admin/hall-templates/' . $template->id, [...$template->toArray(), 'updated_seats' => $template->seats->toArray()])
            ->assertStatus(302)
            ->assertSessionHasErrors(['title', 'updated_seats.*.type']);
    }


    public function test_hall_can_be_deleted_by_admin(): void
    {
        $this->withoutExceptionHandling();

        $template = HallTemplate::factory()->create();

        $this->actingAs($this->admin)->delete('/admin/hall-templates/' . $template->id)
            ->assertRedirect('/admin/hall-templates');

        $this->assertDatabaseMissing('hall_templates', ['id' => $template->id]);
        $this->assertDatabaseMissing('seats', ['hall_id' => $template->id]);
    }


    public function test_non_admin_user_cannot_access_to_movies(): void
    {
        $template = HallTemplate::factory()->create();

        $this->actingAs($this->user)
            ->post('/admin/hall-templates')
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->put('/admin/hall-templates/' . $template->id)
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->delete('/admin/hall-templates/' . $template->id)
            ->assertStatus(403);
    }
}
