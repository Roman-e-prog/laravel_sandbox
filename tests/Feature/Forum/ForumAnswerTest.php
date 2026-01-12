<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use App\Models\User;
use App\Models\Answer;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('shows the create answer form', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $post = Post::factory()->create([
        'ressort' => 'laravel',
        'views' => 0,
    ]);

    $response = $this->get("/forumanswer/{$post->id}/createAnswer");

    $response->assertStatus(200);
    $response->assertViewIs('forumanswer.create');
});

it('creates a new answer', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $post = Post::factory()->create([
        'ressort' => 'laravel',
        'views' => 0,
    ]);

    $response = $this->post("/forumanswer/{$post->id}", [
        'answer_body' => json_encode([
            'ops' => [
                ['insert' => "some answer text\n"],
            ],
        ]),
    ]);

    $response->assertRedirect(
        route('forumposts.detail', [
            'ressort' => $post->ressort,
            'id' => $post->id,
        ])
    );

    $this->assertDatabaseHas('answers', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'questioner_id' => $post->user_id,
        'questioner_name' => $post->username,
    ]);
});

it('shows the edit form', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $answer = Answer::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $this->actingAs($user);

    $response = $this->get("/forumanswer/{$answer->id}/edit");

    $response->assertStatus(200);
    $response->assertViewIs('forumanswer.edit');
});

it('updates an answer', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $answer = Answer::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $this->actingAs($user);

    $response = $this->put("/forumanswer/{$answer->id}", [
        'answer_body' => json_encode([
            'ops' => [
                ['insert' => "some updated text\n"],
            ],
        ]),
    ]);

    $response->assertRedirect(
        route('forumposts.detail', [
            'ressort' => $post->ressort,
            'id' => $post->id,
        ])
    );

    $this->assertDatabaseHas('answers', [
        'id' => $answer->id,
    ]);
});

it('deletes an answer', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    $answer = Answer::factory()->create([
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $this->actingAs($user);

    $response = $this->delete("/forumanswer/{$answer->id}");

    $response->assertRedirect(
        route('forumposts.detail', [
            'ressort' => $post->ressort,
            'id' => $post->id,
        ])
    );

    $this->assertDatabaseMissing('answers', [
        'id' => $answer->id,
    ]);
});

it('allows a user to like an answer', function () {
    $answer = Answer::factory()->create();
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(\App\Livewire\AnswerLikes::class, ['answer' => $answer])
        ->call('like');

    $this->assertDatabaseHas('post_reactions', [
        'answer_id' => $answer->id,
        'user_id' => $user->id,
        'type' => 'like',
    ]);
});

it('an answer can have nested answers', function () {
    $parent = Answer::factory()->create();
    $child = Answer::factory()->create(['parent_id' => $parent->id]);

    $this->assertEquals($parent->id, $child->parent_id);
    $this->assertTrue($parent->children->contains($child));
});
