<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use App\Models\PostReactions;
use App\Models\User;
use Livewire\Livewire;
uses(RefreshDatabase::class);

it('should show posts by ressort', function(){
    $posts = Post::factory()->count(3)->create([
        'ressort' => 'laravel'
    ]);
    $response = $this->get('/forumposts/laravel');

    $response->assertStatus(200);
    $response->assertViewIs('forumposts');
    $response->assertViewHas('posts', function ($viewPosts) use ($posts) {
        return $viewPosts->count() === 3;
    });
});
it('shows the create post form', function () {
    $response = $this->get('/forumposts/laravel/create');

    $response->assertStatus(200);
    $response->assertViewIs('forumposts.create');
    $response->assertViewHas('ressort', 'laravel');
});
it('creates a new post', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/forumposts/laravel', [
    'title' => 'My Post',
    'blog_post_body' => json_encode([
            'ops' => [
                ['insert' => "some body text\n"],
            ],
        ]),
        'slug' => 'my-post',
    ]);


    $response->assertRedirect('/forumposts/laravel');

    $this->assertDatabaseHas('posts', [
        'title' => 'My Post',
        'ressort' => 'laravel',
        'user_id' => $user->id,
    ]);
});
it('shows post detail and increments views', function () {
    $post = Post::factory()->create([
        'ressort' => 'laravel',
        'views' => 0,
    ]);

    $response = $this->get("/forumposts/laravel/{$post->id}");

    $response->assertStatus(200);
    $response->assertViewIs('forumposts.detail');
    $response->assertViewHas('post', fn ($p) => $p->id === $post->id);

    $post->refresh();
    expect($post->views)->toBe(1);
});
it('shows the edit form', function () {
    $post = Post::factory()->create(['ressort' => 'laravel']);
    $user = User::find($post->user_id);
    $this->actingAs($user);

    $response = $this->get("/forumposts/laravel/{$post->id}/edit");

    $response->assertStatus(200);
    $response->assertViewIs('forumposts.edit');
    $response->assertViewHas('post', $post);
});
it('updates a post', function () {
    $post = Post::factory()->create(['ressort' => 'laravel']);
    $user = User::find($post->user_id);
    $this->actingAs($user);

            $response = $this->put("/forumposts/laravel/{$post->id}", [
            'title' => 'Updated Title',
            'blog_post_body' => json_encode([
                'ops' => [
                    ['insert' => "some body text\n"],
                ],
            ]),
            'slug' => 'my-post',
        ]);

    $response->assertRedirect("/forumposts/laravel/{$post->id}");

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => 'Updated Title',
    ]);
});
it('deletes a post', function () {
    $post = Post::factory()->create(['ressort' => 'laravel']);
    $user = User::find($post->user_id);
    $this->actingAs($user);

    $response = $this->delete("/forumposts/laravel/{$post->id}");

    $response->assertRedirect('/forumposts/laravel');

    $this->assertDatabaseMissing('posts', [
        'id' => $post->id,
    ]);
});

it('allows a user to like a post', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(\App\Livewire\PostLikes::class, ['post' => $post])
        ->call('like');

    $this->assertDatabaseHas('post_reactions', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'type' => 'like',
    ]);
});


// it('prevents a user from liking their own post', function () {
//     $post = Post::factory()->create();
//     $user = User::find($post->user_id);

//     $this->actingAs($user);

//     Livewire::test(\App\Livewire\PostLikes::class, ['post' => $post])
//         ->call('like')
//         ->assertDispatched('toastify', function ($event, $payload) {
//         return isset($payload['message'])
//             && $payload['message'] === 'You cannot like your own post';
//     });


// });

// it('prevents liking a post twice', function () {
//     $post = Post::factory()->create();
//     $user = User::find($post->user_id);

//     PostReactions::factory()->create([
//         'post_id' => $post->id,
//         'user_id' => $user->id,
//         'type' => 'like',
//     ]);

//     $this->actingAs($user);

//     Livewire::test(\App\Livewire\PostLikes::class, ['post' => $post])
//         ->call('like')
//         ->assertDispatched('toastify', function ($event, $payload) {
//         return isset($payload['message'])
//             && $payload['message'] === 'Already reacted';
//     });

// });

it('allows a user to dislike a post', function () {
    $post = Post::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(\App\Livewire\PostLikes::class, ['post' => $post])
        ->call('dislike');

    $this->assertDatabaseHas('post_reactions', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'type' => 'dislike',
    ]);
});









