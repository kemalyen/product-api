<?php

namespace Tests\Feature\Api;

use App\Models\Account;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_name_required(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create(['account_id' => $account->id]);

        $response = $this->actingAs($user)->postJson('/api/v1/products', [
            'description' => 'A test product description',
            'price' => 99.99,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('name');
    }

    public function test_product_name_minimum_length(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create(['account_id' => $account->id]);

        $response = $this->actingAs($user)->postJson('/api/v1/products', [
            'name' => 'AB',
            'description' => 'A test product description',
            'price' => 99.99,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('name');
    }

    public function test_product_price_positive(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create(['account_id' => $account->id]);

        $response = $this->actingAs($user)->postJson('/api/v1/products', [
            'name' => 'Test Product',
            'description' => 'A test product description',
            'price' => 0,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('price');
    }

    public function test_user_password_minimum_length(): void
    {
        $account = Account::factory()->create();
        $admin = User::factory()->create(['account_id' => $account->id]);
        $admin->assignRole('Admin');

        $response = $this->actingAs($admin)->postJson('/api/v1/users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'short',
            'role' => 'User',
            'account_id' => $account->id,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('password');
    }
}
