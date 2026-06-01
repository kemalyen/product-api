<?php

namespace Tests\Feature\Api;

use App\Models\Account;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DtoResponseTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_list_returns_dto_format(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create(['account_id' => $account->id]);
        Product::factory()->count(3)->create(['account_id' => $account->id]);

        $response = $this->actingAs($user)->getJson('/api/v1/products');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'description', 'price', 'is_active', 'created_at', 'updated_at']
            ],
            'meta' => ['total', 'per_page', 'current_page', 'last_page']
        ]);
    }

    public function test_product_store_returns_dto_format(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create(['account_id' => $account->id]);
        $category = Category::factory()->create(['account_id' => $account->id]);

        $response = $this->actingAs($user)->postJson('/api/v1/products', [
            'name' => 'Test Product',
            'description' => 'A test product description',
            'price' => 99.99,
            'category_id' => $category->id,
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'id', 'name', 'description', 'price', 'is_active', 'created_at', 'updated_at'
        ]);
    }

    public function test_product_create_with_invalid_price(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create(['account_id' => $account->id]);
        $category = Category::factory()->create(['account_id' => $account->id]);

        $response = $this->actingAs($user)->postJson('/api/v1/products', [
            'name' => 'Test Product',
            'description' => 'A test product description',
            'price' => -10, // Invalid: negative price
            'category_id' => $category->id,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors('price');
    }

    public function test_category_list_returns_dto_format(): void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create(['account_id' => $account->id]);
        Category::factory()->count(3)->create(['account_id' => $account->id]);

        $response = $this->actingAs($user)->getJson('/api/v1/categories');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'description', 'created_at', 'updated_at']
            ],
            'meta' => ['total', 'per_page', 'current_page', 'last_page']
        ]);
    }
}
