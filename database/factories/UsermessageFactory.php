<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usermessage>
 */
class UsermessageFactory extends Factory
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
            'usermessage' => json_encode([
                    'ops' => [
                        ['insert' => $this->faker->paragraph() . "\n"],
                    ],
                ]),
            'is_answered' => false,
            'published_at' => now(),
        ];
    }
}
