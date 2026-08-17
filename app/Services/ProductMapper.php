<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductMapper
{
    /**
     * Map DTO to Product model, detecting changes
     */
    public function mapAndDetectChanges(ProductDTO $dto, ?Product $existingProduct = null): array
    {
        $changes = [];

        if (!$existingProduct) {
            return [
                'product' => Product::create([
                    'sku' => $dto->sku,
                    'barcode' => $dto->barcode,
                    'name' => $dto->name,
                    'price' => $dto->price,
                    'description' => $dto->description,
                    'stock' => $dto->stock,
                    'published_at' => $dto->published_at,
                    'status' => $dto->status,
                ]),
                'changes' => $changes,
                'isNew' => true,
            ];
        }

        // Check for changes
        if ($existingProduct->name !== $dto->name) {
            $changes['name'] = ['old' => $existingProduct->name, 'new' => $dto->name];
            $existingProduct->name = $dto->name;
        }

        if ($existingProduct->price != $dto->price) {
            $changes['price'] = ['old' => $existingProduct->price, 'new' => $dto->price];
            $existingProduct->price = $dto->price;
        }

        if ($existingProduct->description !== $dto->description) {
            $changes['description'] = ['old' => $existingProduct->description, 'new' => $dto->description];
            $existingProduct->description = $dto->description;
        }


        if ($existingProduct->stock != $dto->stock) {
            $changes['stock'] = ['old' => $existingProduct->stock, 'new' => $dto->stock];
            $existingProduct->stock = $dto->stock;
        }

        if ($existingProduct->published_at !== $dto->published_at) {
            $changes['published_at'] = ['old' => $existingProduct->published_at, 'new' => $dto->published_at];
            $existingProduct->published_at = $dto->published_at;
        }

        if ($existingProduct->status !== $dto->status) {
            $changes['status'] = ['old' => $existingProduct->status, 'new' => $dto->status];
            $existingProduct->status = $dto->status;
        }

        if ($existingProduct->barcode !== $dto->barcode) {
            $changes['barcode'] = ['old' => $existingProduct->barcode, 'new' => $dto->barcode];
            $existingProduct->barcode = $dto->barcode;
        }

        if (!empty($changes)) {
            $existingProduct->save();
        }

        return [
            'product' => $existingProduct,
            'changes' => $changes,
            'isNew' => false,
        ];
    }
}
