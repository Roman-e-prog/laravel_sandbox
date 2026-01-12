<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Usermessage;
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
         $user = User::factory()->create(['role'=>'admin']);
         $usermessage = Usermessage::factory()->create();
        return [
            'user_id' => $user->id,
            'adminname' => $user->username,
            'adminmessage' => json_encode([
                    'ops' => [
                        ['insert' => $this->faker->paragraph() . "\n"],
                    ],
                ]),
            'published_at' => now(),
            'has_answered'=>false,
            'questioner_name'=>$usermessage->username,
            'questioner_id'=>$usermessage->user_id,
            'usermessage_id'=>$usermessage->id,
        ];
    }
}
