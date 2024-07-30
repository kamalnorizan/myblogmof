<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Uuid::uuid4(),
            'content' => fake()->paragraph(),
            'post_id' => rand(1, Post::count()),
            'user_id' => rand(1, User::count())
        ];
    }
}
