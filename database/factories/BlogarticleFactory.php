<?php

namespace Database\Factories;

use App\Models\Blogarticle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogarticleFactory extends Factory
{
    protected $model = Blogarticle::class;

    public function definition(): array
    {
        return [
            // Automatically create a user and relate article to it
            'user_id' => User::factory(),

            // Author: in your Livewire you use auth()->user()->username
            // Here we just simulate a name; you can also pull from the user later if you want
            'author' => $this->faker->name(),

            // JSON array, matches cast + migration
            'external_links' => [
                ['url' => 'https://example.com', 'label' => 'Example'],
            ],

            // Text fields
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(160),
            'unit' => $this->faker->randomElement(['1', '2']),
            'ressort' => $this->faker->randomElement(['Laravel', 'HTML', 'CSS']),

            // Quill Delta‑like structure as PHP array
            'article_content' => [
                'ops' => [
                    ['insert' => $this->faker->paragraph()],
                ],
            ],

            // JSON array for tasks
            'tasks' => [
                ['task' => 'testTask', 'description' => 'testDescription'],
            ],

            'published_at' => now(),
            'views' => 0,
        ];
    }
}
