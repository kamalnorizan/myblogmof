<?php

namespace Database\Factories;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid'=> Uuid::uuid4(),
            'title'=> fake()->sentence(),
            'content'=> fake()->paragraph(),
            'author'=> rand(1, User::count())
        ];
    }
}
