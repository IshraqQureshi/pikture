<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gallery_name' => $this->faker->text(15),
            'max_photos' => $this->faker->randomNumber(),
            'max_users' => $this->faker->randomNumber(),
            'expiration_date' => $this->faker->date(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
