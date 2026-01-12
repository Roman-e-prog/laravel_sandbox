<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Usermessage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('creates a usermessage', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(\App\Livewire\Usermessages::class, [
        'userId' => $user->id,
        'username' => $user->username,
    ])
        ->call('setQuillContent', 'usermessage', json_encode([
            'ops' => [
                ['insert' => "Hello admin\n"],
            ],
        ]))
        ->assertDispatched('toast', message: 'Usermessage was successfully created', type: 'success');

    $this->assertDatabaseHas('usermessages', [
        'user_id' => $user->id,
        'username' => $user->username,
        'usermessage' => json_encode([
            'ops' => [
                ['insert' => "Hello admin\n"],
            ],
        ]),
    ]);
});
