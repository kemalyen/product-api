<?php

use App\Http\Resources\ProductResource;
use App\Models\Account;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\User;

use function Pest\Laravel\{get};
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->seed();
    $this->user = User::where('email', 'admin@example.com')->first();
    Sanctum::actingAs(
        $this->user
    );
});

it('creates a new product', function () {
    $catergory = Category::factory()->create();
    $sample = [
        'name' => fake()->unique()->catchPhrase(),
        'description' => fake()->paragraph(),
        'category_id' => $catergory->id,
        'sku' => fake()->unique()->ean8(),
        'barcode' => fake()->ean13(),
        'publishedAt' => fake()->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d H:i'),
        'status' => fake()->randomElement(['A', 'P', 'X']),
        'quantity' => fake()->randomNumber(2),
        'price' => fake()->randomFloat(2, 1, 1000),
    ];

    $response = $this->postJson('/api/' . config('api.version') . '/products', $sample);
    $response->assertStatus(201);

    expect(Product::latest()->first())
        ->name->toBeString()->not->toBeEmpty()
        ->name->toBe($sample['name'])
        ->sku->toBe($sample['sku'])
        ->barcode->toBe($sample['barcode'])
        ->status->toBe($sample['status'])
        ->price->toBe($sample['price'])
        ->quantity->toBe($sample['quantity']);
});

it('updates a product', function () {
    $product = Product::factory()->create();
    $updated_product = Product::factory()->make();

    $sample = [
        'name' => $updated_product->name,
        'sku' => $updated_product->sku,
        'barcode' => $updated_product->barcode,
        'publishedAt' => $updated_product->published_at,
        'status' => $updated_product->status,
        'quantity' => $updated_product->quantity,
        'price' => $updated_product->price,
        'category_id' => $updated_product->category_id
    ];

    $response = $this->put("/api/" . config('api.version') . "/products/{$product->id}", $sample);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes',
                'links'
            ]
        ])
        ->assertJsonFragment([
            'name' => $sample['name'],
            'sku' => $sample['sku'],
            'barcode' => $sample['barcode'],
            'status' => $sample['status'],
            'price' => $sample['price'],
            'quantity' => $sample['quantity'],
        ]);
});

// a product price will assigned to an account

it('can update a product price for a selected account and status will 204', function () {
    $product = Product::factory()->create();

    $account = Account::factory()->create();

    $sample = [
        'price' => fake()->randomFloat(2, 1, 1000),
    ];

    $response = $this->patch("/api/" . config('api.version') . "/accounts/{$account->id}/price/{$product->id}", $sample);
    $response->assertStatus(204);
});
