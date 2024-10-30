<?php

use App\Http\Resources\ProductResource;
use App\Models\Account;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Arr;

use function Pest\Laravel\{get};
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->seed();
    $user = User::where('email', 'test@example.com')->first();
    Sanctum::actingAs(
        $user
    );
});

it('has product page', function () {
    $response = get('/api/products');
    $response->assertStatus(200);
});

it('gets the list of the products', function () {
    Product::factory()->create();
    $count = Product::count();
    $response = get('/api/products');
    $response->assertJsonCount($count, 'data');
});


it('shows a single product', function () {
    $product = Product::factory()->create();
    $resource = new ProductResource(
        $product
    );
    $data = $resource->response()->getData(true);
    $response = get("/api/products/{$product->id}");
    $response->assertStatus(200)->assertJson($data);
});



it('creates a new product', function () {
    $catergory = Category::factory()->create();
    $sample = [
        'name' => fake()->unique()->catchPhrase(),
        'category_id' => $catergory->id,
        'sku' => fake()->unique()->ean8(),
        'barcode' => fake()->ean13(),
        'publishedAt' => fake()->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d H:i'),
        'status' => fake()->randomElement(['A', 'P', 'X']),
        'quantity' => fake()->randomNumber(2),
        'price' => fake()->randomFloat(2, 1, 1000),
    ];

    $response = $this->post('/api/products', $sample);
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

    $user = User::where('email', 'admin@example.com')->first();
    Sanctum::actingAs(
        $user
    );

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

    $response = $this->put("/api/products/{$product->id}", $sample);

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
    /* 
    expect($product)
        ->name->toBeString()->not->toBeEmpty()
        ->name->toBe($product->name)
        ->sku->toBe($sample['sku'])
        ->barcode->toBe($sample['barcode'])
        ->published_at->format('Y-m-d H:i')->toBe($sample['published_at'])
        ->status->toBe($sample['status'])
        ->price->toBe($sample['price'])
        ->price->not->toBe($product->price)
        ->quantity->toBe($sample['quantity']); */
});
