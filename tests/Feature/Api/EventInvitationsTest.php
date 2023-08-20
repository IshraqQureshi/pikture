<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventInvitationsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_event_invitations(): void
    {
        $event = Event::factory()->create();
        $invitations = Invitation::factory()
            ->count(2)
            ->create([
                'event_id' => $event->id,
            ]);

        $response = $this->getJson(
            route('api.events.invitations.index', $event)
        );

        $response->assertOk()->assertSee($invitations[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_event_invitations(): void
    {
        $event = Event::factory()->create();
        $data = Invitation::factory()
            ->make([
                'event_id' => $event->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.events.invitations.store', $event),
            $data
        );

        $this->assertDatabaseHas('invitations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $invitation = Invitation::latest('id')->first();

        $this->assertEquals($event->id, $invitation->event_id);
    }
}
