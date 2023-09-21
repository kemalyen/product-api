<?php

use App\Models\User;

use function Pest\Laravel\{get};

it('logins as a user', function () {
    $user = User::factory()->create(
        [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]
    );

    $response = $this->postJson('/login', ['email' => $user->email, 'password' => 'password']);
    $response->assertStatus(200);
});


it('tries to login with invalid email', function () {
    $user = User::factory()->create(
        [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]
    );

    $response = $this->postJson('/login', ['email' => 'john@example.org', 'password' => 'password']);
    $response->assertStatus(422)
        ->assertJson([
            'message' => 'These credentials do not match our records.',
            'errors' => [
                'email' => [
                    'These credentials do not match our records.'
                ]
            ]
        ]);
});


it('tries to login with invalid password', function () {
    $user = User::factory()->create(
        [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            'email_verified_at' => now(),
        ]
    );

    $response = $this->postJson('/login', ['email' => $user->email, 'password' => 'password**']);
    $response->assertStatus(422)
        ->assertJson([
            'message' => 'These credentials do not match our records.'
        ]);
});
