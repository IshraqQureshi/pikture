<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment' => $this->faker->text(),
            'photo_id' => \App\Models\Photo::factory(),
        ];
    }
}
