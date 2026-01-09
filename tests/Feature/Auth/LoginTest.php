<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase; 
uses(RefreshDatabase::class);

it('requires an email', function () {
    $response = $this->post('/login', [
        'email' => '',
        'password' => 'secret123',
    ]);

    $response->assertSessionHasErrors('email');
});


it('logins a new user', function () {
    $user = User::factory()->create([ 
        'prename' => 'Roman',
        'lastname' => 'Tester',
        'username' => 'roman123',
        'street'=>'Teststr',
        'housenumber'=>'11',
        'postal_code'=>'12345',
        'town'=>'Teststadt',
        'email' => 'roman@example.com',
        'password' => bcrypt('secret123'), ]);
    $response = $this->post('/login', [
        'email' => 'roman@example.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect('/');

    $this->assertDatabaseHas('users', [
        'email' => 'roman@example.com',
    ]);
});

it('does not login a user with invalid data', function () {
    $user = User::factory()->create([ 
        'prename' => 'Roman',
        'lastname' => 'Tester',
        'username' => 'roman123',
        'street'=>'Teststr',
        'housenumber'=>'11',
        'postal_code'=>'12345',
        'town'=>'Teststadt',
        'email' => 'roman@example.com',
        'password' => bcrypt('secret123'),
    ]);
    $response = $this->post('/login', [
        'email' => '', // invalid
        'password' => 'secret123',
    ]);
    $response->assertSessionHasErrors('email');
    $response->assertRedirect(); // redirects back to /register

});
