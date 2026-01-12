<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Usermessage;

class UsermessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'username' => function (array $attributes) {
                return User::find($attributes['user_id'])->username;
            },
            'usermessage' => json_encode([
                'ops' => [
                    ['insert' => $this->faker->paragraph() . "\n"],
                ],
            ]),
            'published_at' => now(),
            'is_answered' => false,
        ];
    }
}
