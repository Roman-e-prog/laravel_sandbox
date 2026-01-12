<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Usermessage;
use App\Models\Adminmessage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('creates an adminmessage as answer', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $usermessage = Usermessage::factory()->create([
        'username' => 'TestUser',
        'usermessage' => json_encode([
            'ops' => [
                ['insert' => "Hello admin\n"],
            ],
        ]),
    ]);

    Livewire::test(\App\Livewire\Adminmessages::class)
        // select the user as recipient
        ->call('setUser', $usermessage->user_id, $usermessage->username, $usermessage->id)

        // simulate quill sending content
        ->call('setQuillContent', 'adminmessage', json_encode([
            'ops' => [
                ['insert' => "My answer on your message\n"],
            ],
        ]))

        // finalize submit (this triggers createAdminmessage)
        ->call('finalizeSubmit')

        // assert toast event
        ->assertDispatched('toast', message: 'Adminmessage was successfully created', type: 'success');

    $this->assertDatabaseHas('adminmessages', [
        'user_id' => $admin->id,
        'adminname' => $admin->username,
        'has_answered' => true,
        'questioner_name' => $usermessage->username,
        'questioner_id' => $usermessage->user_id,
        'usermessage_id' => $usermessage->id,
    ]);
});
it('creates a direct adminmessage', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $user = User::factory()->create();

    Livewire::test(\App\Livewire\Adminmessages::class)
        ->call('setUser', $user->id, $user->username, null)

        ->call('setQuillContent', 'adminmessage', json_encode([
            'ops' => [
                ['insert' => "My message to the user\n"],
            ],
        ]))

        ->call('finalizeSubmit')

        ->assertDispatched('toast', message: 'Adminmessage was successfully created', type: 'success');

    $this->assertDatabaseHas('adminmessages', [
        'user_id' => $admin->id,
        'adminname' => $admin->username,
        'questioner_name' => $user->username,
        'questioner_id' => $user->id,
        'usermessage_id' => null,
    ]);
});

it('edits an adminmessage', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $adminmessage = Adminmessage::factory()->create([
        'user_id' => $admin->id,
        'adminname' => $admin->username,
        'adminmessage' => json_encode([
            'ops' => [
                ['insert' => "Old message\n"],
            ],
        ]),
    ]);

    Livewire::test(\App\Livewire\Adminmessages::class)
        ->call('editAdminmessage', $adminmessage->id)

        ->call('setQuillContent', 'adminmessage', json_encode([
            'ops' => [
                ['insert' => "My updated message to the user\n"],
            ],
        ]))

        ->call('finalizeSubmit')

        ->assertDispatched('toast', message: 'Adminmessage was successfully updated', type: 'success');

    $this->assertDatabaseHas('adminmessages', [
        'id' => $adminmessage->id,
        'adminmessage' => json_encode([
            'ops' => [
                ['insert' => "My updated message to the user\n"],
            ],
        ]),
    ]);
});

it('deletes an adminmessage', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $adminmessage = Adminmessage::factory()->create([
        'user_id' => $admin->id,
    ]);

    Livewire::test(\App\Livewire\Adminmessages::class)
        ->call('deleteAdminmessage', $adminmessage->id);

    $this->assertDatabaseMissing('adminmessages', [
        'id' => $adminmessage->id,
    ]);
});
