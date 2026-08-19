<?php

use App\Http\Resources\ProductResource;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\User;

use function Pest\Laravel\{get, delete};
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->seed();
    $this->admin = User::where('email', 'admin@example.com')->first();
    $this->user = User::where('email', 'test@example.com')->first();
});

describe('Product CRUD', function () {

    it('lists products', function () {
        $product = Product::first();

        Sanctum::actingAs($this->admin);

        $response = get('/api/' . config('api.version') . '/products');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'type',
                        'id',
                        'attributes' => [
                            'name',
                            'description',
                            'sku',
                            'barcode',
                            'publishedAt',
                            'status',
                            'stock',
                            'price',
                        ],
                        'links',
                    ],
                ],
            ])
            ->assertJsonFragment([
                'name' => $product->name,
                'sku' => $product->sku,
                'barcode' => $product->barcode,
            ]);
    });

    it('shows a single product', function () {
        $product = Product::factory()->create();
        $resource = new ProductResource($product);
        $data = $resource->response()->getData(true);

        Sanctum::actingAs($this->admin);

        $response = get("/api/" . config('api.version') . "/products/{$product->id}");
        $response->assertStatus(200)
            ->assertJson($data);
    });

    it('returns validation errors when creating a product with invalid data', function () {
        Sanctum::actingAs($this->admin);

        $response = $this->postJson('/api/' . config('api.version') . '/products', []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'description', 'price', 'sku', 'barcode']);
    });

    it('updates a product', function () {
        $product = Product::factory()->create();
        $updatedProduct = Product::factory()->make();

        $sample = [
            'name' => $updatedProduct->name,
            'description' => $updatedProduct->description,
            'sku' => $updatedProduct->sku,
            'barcode' => $updatedProduct->barcode,
            'published_at' => $updatedProduct->published_at->format('Y-m-d H:i'),
            'status' => $updatedProduct->status,
            'stock' => $updatedProduct->stock,
            'price' => $updatedProduct->price
        ];

        Sanctum::actingAs($this->admin);

        $response = $this->putJson("/api/" . config('api.version') . "/products/{$product->id}", $sample);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes',
                    'links',
                ],
            ])
            ->assertJsonFragment([
                'name' => $sample['name'],
                'sku' => $sample['sku'],
                'barcode' => $sample['barcode'],
                'status' => $sample['status'],
                'price' => $sample['price'],
                'stock' => $sample['stock'],
            ]);

        $product->refresh();
        expect($product)
            ->name->toBe($sample['name'])
            ->sku->toBe($sample['sku'])
            ->barcode->toBe($sample['barcode'])
            ->status->toBe($sample['status'])
            ->stock->toBe($sample['stock']);
    });

    it('returns validation errors when updating a product with invalid data', function () {
        $product = Product::factory()->create();

        Sanctum::actingAs($this->admin);

        $response = $this->putJson("/api/" . config('api.version') . "/products/{$product->id}", [
            'name' => 'ab',
            'price' => -10,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price']);
    });

    it('deletes a product', function () {
        $product = Product::factory()->create();

        Sanctum::actingAs($this->admin);

        $response = delete("/api/" . config('api.version') . "/products/{$product->id}");
        $response->assertStatus(204);

        expect(Product::find($product->id))->toBeNull();
    });

    it('returns 403 when a non-admin user creates a product', function () {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/' . config('api.version') . '/products', [
            'name' => 'Test Product',
            'description' => fake()->paragraph(),
            'sku' => fake()->unique()->ean8(),
            'barcode' => fake()->ean13(),
            'price' => fake()->randomFloat(2, 1, 1000),
        ]);

        $response->assertStatus(403);
    });

    it('returns 403 when a non-admin user updates a product', function () {
        $product = Product::factory()->create();

        Sanctum::actingAs($this->user);

        $response = $this->putJson("/api/" . config('api.version') . "/products/{$product->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(403);
    });

    it('returns 403 when a non-admin user deletes a product', function () {
        $product = Product::factory()->create();

        Sanctum::actingAs($this->user);

        $response = delete("/api/" . config('api.version') . "/products/{$product->id}");
        $response->assertStatus(403);
    });
});

describe('Product Price Update', function () {
    it('can update a product price for a selected account', function () {
        $product = Product::factory()->create();
        $account = Account::factory()->create();

        $sample = [
            'price' => fake()->randomFloat(2, 1, 1000),
        ];

        Sanctum::actingAs($this->admin);

        $response = $this->patch("/api/" . config('api.version') . "/accounts/{$account->id}/price/{$product->id}", $sample);
        $response->assertStatus(204);

        $this->assertDatabaseHas('product_prices', [
            'account_id' => $account->id,
            'product_id' => $product->id,
            'price' => $sample['price'],
        ]);
    });

    it('returns 403 when a non-admin user updates a product price', function () {
        $product = Product::factory()->create();
        $account = Account::factory()->create();

        Sanctum::actingAs($this->user);

        $response = $this->patch("/api/" . config('api.version') . "/accounts/{$account->id}/price/{$product->id}", [
            'price' => fake()->randomFloat(2, 1, 1000),
        ]);

        $response->assertStatus(403);
    });
});
