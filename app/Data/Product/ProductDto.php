<?php

namespace App\Data\Product;

use App\Data\Dto;
use Illuminate\Database\Eloquent\Model;

class ProductDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $sku,
        public readonly string $barcode,
        public readonly string $published_at,
        public readonly string $description,
        public readonly float $price,
        public readonly float $account_price,
        public readonly int $quantity,
        public readonly string $status,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {}

    public static function from(Model $model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            sku: $model->sku,
            barcode: $model->barcode,
            published_at: $model->published_at,
            description: $model->description,
            price: (float) $model->price,
            account_price: (float) $model->account_price,
            quantity: $model->quantity,
            status: $model->status,
            created_at: $model->created_at->toIso8601String(),
            updated_at: $model->updated_at->toIso8601String(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'published_at' => $this->published_at,
            'description' => $this->description,
            'price' => $this->price,
            'account_price' => (float) $this->account_price,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
