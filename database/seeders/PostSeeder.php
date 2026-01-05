<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'title'=>'My first blogPost',
            'body'=>'This is the body of the first blogPost'
        ]);
        Post::create([
            'title'=>'My second blogPost',
            'body'=>'This is the body of the second blogPost'
        ]);
    }
}
