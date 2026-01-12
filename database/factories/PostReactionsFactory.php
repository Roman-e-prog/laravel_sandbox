<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;
class PostReactionsFactory extends Factory
{
    protected $model = \App\Models\PostReactions::class;

    public function definition()
    {
        return [
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            'type' => 'like',
        ];
    }
}
