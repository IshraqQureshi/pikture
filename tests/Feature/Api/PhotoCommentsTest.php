<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Photo;
use App\Models\Comment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PhotoCommentsTest extends TestCase
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
    public function it_gets_photo_comments(): void
    {
        $photo = Photo::factory()->create();
        $comments = Comment::factory()
            ->count(2)
            ->create([
                'photo_id' => $photo->id,
            ]);

        $response = $this->getJson(route('api.photos.comments.index', $photo));

        $response->assertOk()->assertSee($comments[0]->comment);
    }

    /**
     * @test
     */
    public function it_stores_the_photo_comments(): void
    {
        $photo = Photo::factory()->create();
        $data = Comment::factory()
            ->make([
                'photo_id' => $photo->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.photos.comments.store', $photo),
            $data
        );

        $this->assertDatabaseHas('comments', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $comment = Comment::latest('id')->first();

        $this->assertEquals($photo->id, $comment->photo_id);
    }
}
