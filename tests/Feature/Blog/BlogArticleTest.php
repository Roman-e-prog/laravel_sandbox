<?php

use App\Livewire\DashboardArticles;
use App\Models\Blogarticle;
use App\Models\BlogarticleImages;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);


it('forbids non-admin users from creating articles', 
function () { 
    $user = User::factory()->create(['role' => 'user']); 
    Livewire::actingAs($user)
        ->test(DashboardArticles::class)
        ->assertForbidden();  
});

it('creates a blog article with valid data via dashboard', function () {
    // Arrange: create a user with a username (used as author)
    $user = User::factory()->create([
        'role'=>'admin',
        'username' => 'roman123',
    ]);

    // Act: simulate Livewire component as this user
    Livewire::actingAs($user)
        ->test(DashboardArticles::class)
        // Set required fields
        ->set('title', 'My Test Article')
        ->set('ressort', 'Laravel')
        ->set('unit', '1')
        ->set('description', 'Short description')
        ->set('article_content', [
            'ops' => [
                ['insert' => 'Some content'],
            ],
        ])
        ->set('tasks', [
            ['task' => 'First task', 'description' => 'Task description'],
        ])
        ->set('external_links', [
            ['url' => 'https://example.com', 'label' => 'Example'],
        ])
        // No images for now (simplify first)
        ->call('createArticle')
        // Assert that the toast event was dispatched
        ->assertDispatched('toast', message: 'Article was successfully created', type: 'success');

    // Assert: database has the article
    $this->assertDatabaseHas('blogarticles', [
        'title' => 'My Test Article',
        'ressort' => 'Laravel',
        'unit' => '1',
        'description' => 'Short description',
        'user_id' => $user->id,
        'author' => 'roman123',
    ]);

    // Optional: inspect the created article and its JSON fields
    $article = Blogarticle::first();

    expect($article->article_content)
        ->toBeArray()
        ->and($article->article_content['ops'][0]['insert'])
        ->toBe('Some content');

    expect($article->tasks)
        ->toBeArray()
        ->and($article->tasks[0]['task'])
        ->toBe('First task');

    expect($article->external_links)
        ->toBeArray()
        ->and($article->external_links[0]['url'])
        ->toBe('https://example.com');
});

it('updates a blog article via dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'username' => 'roman123',
    ]);

    $article = Blogarticle::factory()->create([
        'title' => 'Old Title',
        'ressort' => 'Laravel',
        'unit' => '1',
        'description' => 'Old description',
        'article_content' => ['ops' => [['insert' => 'Old content']]],
    ]);

    Livewire::actingAs($admin)
        ->test(DashboardArticles::class)
        ->call('editArticle', $article->id)
        ->set('title', 'Updated Title')
        ->set('description', 'Updated description')
        ->set('article_content', ['ops' => [['insert' => 'Updated content']]])
        ->call('updateArticle')
        ->assertDispatched('toast', message: 'Article was successfully updated', type: 'success');

    $article->refresh();

    expect($article->title)->toBe('Updated Title');
    expect($article->description)->toBe('Updated description');
    expect($article->article_content['ops'][0]['insert'])->toBe('Updated content');
});
it('deletes a blog article via dashboard', 
function () { $admin = User::factory()->create(['role' => 'admin']); 
    $article = Blogarticle::factory()->create(); 
    Livewire::actingAs($admin) ->test(DashboardArticles::class) ->call('deleteArticle', $article->id); $this->assertDatabaseMissing('blogarticles', [ 'id' => $article->id, ]); 
});


