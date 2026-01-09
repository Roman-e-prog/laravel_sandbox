<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'username' => $this->faker->userName(),
            'ressort' => 'laravel',
            'title' => $this->faker->sentence(),
            'answer_body' => json_encode([
                    'ops' => [
                        ['insert' => $this->faker->paragraph() . "\n"],
                    ],
                ]),
            'images_path' => null,
            'is_admin' => false,
            'questioner_id'=>$this->faker->randomElement(['1', '2']),
            'questioner_name'=>$this->faker->userName(),
            'views' => 0,
            'is_answered' => false,
            'published_at' => now(),
            'slug' => $this->faker->slug(),
            'status' => 'draft',
        ];
    }
}
