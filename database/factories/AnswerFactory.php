<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

class AnswerFactory extends Factory
{
    public function definition(): array
    {
        return [
            // The post this answer belongs to
            'post_id' => Post::factory(),

            // The user who writes the answer
            'user_id' => User::factory(),

            // Derived from the answer's user
            'username' => function (array $attributes) {
                return User::find($attributes['user_id'])->username;
            },

            // Quill delta as JSON string
            'answer_body' => json_encode([
                'ops' => [
                    ['insert' => $this->faker->paragraph() . "\n"],
                ],
            ]),

            'is_admin' => false,

            // Derived from the post's author (the questioner)
            'questioner_id' => function (array $attributes) {
                return Post::find($attributes['post_id'])->user_id;
            },

            'questioner_name' => function (array $attributes) {
                $post = Post::find($attributes['post_id']);
                return optional($post->user)->username ?? 'unknown';
            },

            'published_at' => now(),
        ];
    }
}

