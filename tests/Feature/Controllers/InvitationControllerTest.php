<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Invitation;

use App\Models\Event;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_invitations(): void
    {
        $invitations = Invitation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('invitations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.invitations.index')
            ->assertViewHas('invitations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_invitation(): void
    {
        $response = $this->get(route('invitations.create'));

        $response->assertOk()->assertViewIs('app.invitations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_invitation(): void
    {
        $data = Invitation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('invitations.store'), $data);

        $this->assertDatabaseHas('invitations', $data);

        $invitation = Invitation::latest('id')->first();

        $response->assertRedirect(route('invitations.edit', $invitation));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_invitation(): void
    {
        $invitation = Invitation::factory()->create();

        $response = $this->get(route('invitations.show', $invitation));

        $response
            ->assertOk()
            ->assertViewIs('app.invitations.show')
            ->assertViewHas('invitation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_invitation(): void
    {
        $invitation = Invitation::factory()->create();

        $response = $this->get(route('invitations.edit', $invitation));

        $response
            ->assertOk()
            ->assertViewIs('app.invitations.edit')
            ->assertViewHas('invitation');
    }

    /**
     * @test
     */
    public function it_updates_the_invitation(): void
    {
        $invitation = Invitation::factory()->create();

        $event = Event::factory()->create();

        $data = [
            'email' => $this->faker->email(),
            'event_id' => $event->id,
        ];

        $response = $this->put(route('invitations.update', $invitation), $data);

        $data['id'] = $invitation->id;

        $this->assertDatabaseHas('invitations', $data);

        $response->assertRedirect(route('invitations.edit', $invitation));
    }

    /**
     * @test
     */
    public function it_deletes_the_invitation(): void
    {
        $invitation = Invitation::factory()->create();

        $response = $this->delete(route('invitations.destroy', $invitation));

        $response->assertRedirect(route('invitations.index'));

        $this->assertModelMissing($invitation);
    }
}
