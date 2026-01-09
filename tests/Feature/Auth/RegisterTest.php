<?php
use Illuminate\Foundation\Testing\RefreshDatabase; 
uses(RefreshDatabase::class);

it('requires an email', function () {
    $response = $this->post('/register', [
        'prename' => 'Roman',
        'lastname' => 'Tester',
        'username' => 'roman123',
        'email' => '',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertSessionHasErrors('email');
});


it('registers a new user', function () {
    $response = $this->post('/register', [
        'prename' => 'Roman',
        'lastname' => 'Tester',
        'username' => 'roman123',
        'street'=>'Teststr',
        'housenumber'=>'11',
        'postal_code'=>'12345',
        'town'=>'Teststadt',
        'email' => 'roman@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertRedirect('/login');

    $this->assertDatabaseHas('users', [
        'email' => 'roman@example.com',
    ]);
});

it('does not register a user with invalid data', function () {
    $response = $this->post('/register', [
        'prename' => 'Roman',
        'lastname' => 'Tester',
        'username' => 'roman123',
        'email' => '', // invalid
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ]);

    $response->assertSessionHasErrors('email');
    $response->assertRedirect(); // redirects back to /register

    $this->assertDatabaseMissing('users', [
        'username' => 'roman123',
    ]);
});
