<?php

use App\Http\Resources\ProductResource;
use App\Models\Account;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\User;
use Database\Factories\ProductPriceFactory;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\{get};
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->seed();
    // this is an API user, so it can access the API endpoints
    $this->user = User::where('email', 'test@example.com')->first();
    Sanctum::actingAs(
        $this->user
    );
    Sanctum::actingAs(
        $this->user
    );
});

it('shows a single product price for an account', function () {
    $productPrice = ProductPriceFactory::new()->create([
        'account_id' => $this->user->account_id,
    ]);

    $product = $productPrice->product;
    $product_price = $product->price;
    $account_product_price = $productPrice->price;

    $resource = new ProductResource(
        $product
    );
    $data = $resource->response()->getData(true);

    Log::debug('Product Id: ' . $product->id);
    Log::info('Product Price: ' . $product_price);
    Log::info('Account Product Price: ' . $account_product_price);

    $response = get("/api/" . config('api.version') . "/products/{$product->id}");
    $response->assertStatus(200)->assertJson($data)
        ->assertJsonFragment([
            'price' => $account_product_price,
        ]);
});

it('shows a single product general price for an account', function () {
    $product = Product::factory()->create();
    $resource = new ProductResource(
        $product
    );
    $data = $resource->response()->getData(true);
    $response = get("/api/" . config('api.version') . "/products/{$product->id}");
    $response->assertStatus(200)->assertJson($data)->assertJsonFragment([
        'price' => $product->price,
    ]);
});
