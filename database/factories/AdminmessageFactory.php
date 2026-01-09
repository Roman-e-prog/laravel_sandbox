<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adminmessage>
 */
class AdminmessageFactory extends Factory
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
            'adminname' => $this->faker->userName(),
            'adminmessage' => json_encode([
                    'ops' => [
                        ['insert' => $this->faker->paragraph() . "\n"],
                    ],
                ]),
            'published_at' => now(),
            'has_answered'=>false,
            'questioner_name'=> $this->faker->userName(),
            'questioner_id'=>$this->faker->randomElement(['1', '2']),
            'usermessage_id'=>$this->faker->randomElement(['1', '2']),
        ];
    }
}
