<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\Models\Product;

class ProductUpdateStrategy
{
    public function __construct(private ProductMapper $mapper) {}

    public function execute(ProductDTO $dto): array
    {
        $existingProduct = Product::where('sku', $dto->sku)->first();
        $result = $this->mapper->mapAndDetectChanges($dto, $existingProduct);

        return [
            'sku' => $dto->sku,
            'product_id' => $result['product']->id,
            'updated' => !empty($result['changes']),
            'changes' => $result['changes'],
            'isNew' => $result['isNew'],
        ];
    }
}
