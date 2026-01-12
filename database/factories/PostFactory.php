<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;
class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'username' => $this->faker->userName(),
            'ressort' => 'laravel',
            'title' => $this->faker->sentence(),
            'blog_post_body' => json_encode([
                    'ops' => [
                        ['insert' => $this->faker->paragraph() . "\n"],
                    ],
                ]),
            'images_path' => null,
            'is_admin' => false,
            'views' => 0,
            'is_answered' => false,
            'published_at' => now(),
            'slug' => $this->faker->slug(),
            'status' => 'draft',
        ];
    }
}
