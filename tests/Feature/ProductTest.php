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

    $this->user = User::where('email', 'test@example.com')->first();
    Sanctum::actingAs(
        $this->user
    );
});

it('has product page', function () {
    $response = get('/api/' . config('api.version') . '/products');
    $response->assertStatus(200);
});

it('gets the list of the products', function () {
    $product = Product::first();

    $response = get('/api/' . config('api.version') . '/products');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                [
                    'type',
                    'id',
                    'attributes',
                    'links'
                ]
            ]
        ])
        ->assertJsonFragment([
            'name' => $product->name,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'status' => $product->status,
            'quantity' => $product->quantity,
        ]);
});


it('shows a single product', function () {
    $product = Product::factory()->create();
    $resource = new ProductResource(
        $product
    );
    $data = $resource->response()->getData(true);
    $response = get("/api/" . config('api.version') . "/products/{$product->id}");
    $response->assertStatus(200)->assertJson($data);
});
