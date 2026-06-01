<?php

namespace App\Data\Product;

use App\Data\Dto;

class UpdateProductDto extends Dto
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $description = null,
        public readonly ?float $price = null,
        public readonly ?int $category_id = null,
        public readonly ?bool $is_active = null,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            name: $request->input('name'),
            description: $request->input('description'),
            price: $request->input('price') !== null ? (float) $request->input('price') : null,
            category_id: $request->input('category_id'),
            is_active: $request->input('is_active'),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
        ], fn($value) => $value !== null);
    }
}
