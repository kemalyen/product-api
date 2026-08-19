<?php

use App\Enums\ProductStatus;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\artisan;

it('exports products to a csv file', function () {
    Storage::fake('internal');

    $product = Product::factory()->create([
        'sku' => 'EXPORT001',
        'barcode' => '123456789',
        'description' => 'Product, with a comma',
        'status' => ProductStatus::ACTIVE->value,
        'price' => 12.5,
        'stock' => 8,
    ]);

    $exitCode = artisan('export-products', [
        '--disk' => 'internal',
        '--path' => 'out',
    ]);

    expect($exitCode)->toBe(0);

    $files = Storage::disk('internal')->files('out');
    expect($files)->toHaveCount(1);

    $rows = array_map('str_getcsv', explode("\n", trim(Storage::disk('internal')->get($files[0]))));

    expect($rows[0])->toBe([
        'sku',
        'barcode',
        'name',
        'description',
        'published_at',
        'status',
        'price',
        'stock',
    ]);
    expect($rows[1])->toBe([
        $product->sku,
        $product->barcode,
        $product->name,
        $product->description,
        $product->published_at?->format('Y-m-d H:i:s'),
        $product->status,
        '12.5',
        '8',
    ]);
});

it('can filter exported products by status', function () {
    Storage::fake('internal');

    Product::factory()->create([
        'sku' => 'ACTIVE001',
        'status' => ProductStatus::ACTIVE->value,
    ]);
    Product::factory()->create([
        'sku' => 'PENDING001',
        'status' => ProductStatus::PENDING->value,
    ]);

    $exitCode = artisan('export-products', [
        '--disk' => 'internal',
        '--path' => 'out',
        '--status' => ProductStatus::ACTIVE->value,
    ]);

    expect($exitCode)->toBe(0);

    $files = Storage::disk('internal')->files('out');
    $rows = array_map('str_getcsv', explode("\n", trim(Storage::disk('internal')->get($files[0]))));

    expect($rows)->toHaveCount(2)
        ->and($rows[1][0])->toBe('ACTIVE001');
});
