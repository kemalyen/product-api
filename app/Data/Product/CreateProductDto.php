<?php

namespace App\Data\Product;

use App\Data\Dto;

class CreateProductDto extends Dto
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly float $price,
        public readonly ?int $category_id = null,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            name: $request->input('name'),
            description: $request->input('description'),
            price: (float) $request->input('price'),
            category_id: $request->input('category_id'),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
        ];
    }
}
