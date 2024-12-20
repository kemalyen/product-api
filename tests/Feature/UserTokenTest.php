<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\{get};

it('logins as a user', function () {
    Role::create(['name' => 'Account Api User']);
    $user = User::factory()->create(
        [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]
    )->assignRole('Account Api User');

    $response = $this->postJson('/api/token', ['email' => $user->email, 'password' => 'password']);
    $response->assertStatus(200);

    $response->assertJsonStructure([
        'success' => [
            'token'
        ],
    ]);
});

it('tries to login with invalid email', function () {
    $user = User::factory()->create(
        [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ]
    );

    $response = $this->postJson('/api/token', ['email' => 'john@example.org', 'password' => 'password']);
    $response->assertStatus(401)
        ->assertJson([
            'error' => 'Your credentials are wrong!',
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

    $response = $this->postJson('/api/token', ['email' => $user->email, 'password' => 'password**']);
    $response->assertStatus(401)
        ->assertJson([
            'error' => 'Your credentials are wrong!'
        ]);
});
