<?php

use App\Models\User;

use function Pest\Laravel\{get};

it('registers a user', function () {
    $user = [
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    $response = $this->postJson('/register', $user);
    $response->assertStatus(201);

    expect(User::latest()->first())
        ->name->toBeString()->not->toBeEmpty()
        ->name->toBe($user['name'])
        ->email->toBe($user['email']);
});

it('creates a new token', function () {
    $user = User::factory()->create();
    $token = $user->createToken('api-token')->plainTextToken;

    $this->getJson('/api/products', ['Authorization' => 'Bearer ' . $token])
        ->assertStatus(200);
});