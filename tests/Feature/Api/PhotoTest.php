<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Photo;

use App\Models\Event;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhotoTest extends TestCase
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
    public function it_gets_photos_list(): void
    {
        $photos = Photo::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.photos.index'));

        $response->assertOk()->assertSee($photos[0]->photo);
    }

    /**
     * @test
     */
    public function it_stores_the_photo(): void
    {
        $data = Photo::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.photos.store'), $data);

        $this->assertDatabaseHas('photos', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_photo(): void
    {
        $photo = Photo::factory()->create();

        $event = Event::factory()->create();

        $data = [
            'photo' => $this->faker->text(10),
            'event_id' => $event->id,
        ];

        $response = $this->putJson(route('api.photos.update', $photo), $data);

        $data['id'] = $photo->id;

        $this->assertDatabaseHas('photos', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_photo(): void
    {
        $photo = Photo::factory()->create();

        $response = $this->deleteJson(route('api.photos.destroy', $photo));

        $this->assertModelMissing($photo);

        $response->assertNoContent();
    }
}
