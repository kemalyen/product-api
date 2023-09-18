<?php

use App\Models\Product;
use App\Models\User;
use function Pest\Laravel\{get};
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    Sanctum::actingAs(
        User::factory()->create()
    );
});

it('has product page', function () {
    $response = get('/api/products');
    $response->assertStatus(200);
});

it('get the list of the products', function () {
    Product::factory()->create();
    $count = Product::count();
    $response = get('/api/products');
    $response->assertJsonCount($count, 'data');
});


it('show the a products', function () {
    $product = Product::factory()->create();
    $response = get("/api/products/{$product->id}");
    $data = [
        'data' => [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'published_at' => $product->published_at->format('Y-m-d H:i:s'),
            'status' => $product->status,
        ]
    ];
    $response->assertStatus(200)->assertJson($data);
});
