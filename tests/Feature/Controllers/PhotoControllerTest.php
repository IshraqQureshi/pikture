<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Photo;

use App\Models\Event;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhotoControllerTest extends TestCase
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
    public function it_displays_index_view_with_photos(): void
    {
        $photos = Photo::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('photos.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.photos.index')
            ->assertViewHas('photos');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_photo(): void
    {
        $response = $this->get(route('photos.create'));

        $response->assertOk()->assertViewIs('app.photos.create');
    }

    /**
     * @test
     */
    public function it_stores_the_photo(): void
    {
        $data = Photo::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('photos.store'), $data);

        $this->assertDatabaseHas('photos', $data);

        $photo = Photo::latest('id')->first();

        $response->assertRedirect(route('photos.edit', $photo));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_photo(): void
    {
        $photo = Photo::factory()->create();

        $response = $this->get(route('photos.show', $photo));

        $response
            ->assertOk()
            ->assertViewIs('app.photos.show')
            ->assertViewHas('photo');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_photo(): void
    {
        $photo = Photo::factory()->create();

        $response = $this->get(route('photos.edit', $photo));

        $response
            ->assertOk()
            ->assertViewIs('app.photos.edit')
            ->assertViewHas('photo');
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

        $response = $this->put(route('photos.update', $photo), $data);

        $data['id'] = $photo->id;

        $this->assertDatabaseHas('photos', $data);

        $response->assertRedirect(route('photos.edit', $photo));
    }

    /**
     * @test
     */
    public function it_deletes_the_photo(): void
    {
        $photo = Photo::factory()->create();

        $response = $this->delete(route('photos.destroy', $photo));

        $response->assertRedirect(route('photos.index'));

        $this->assertModelMissing($photo);
    }
}
