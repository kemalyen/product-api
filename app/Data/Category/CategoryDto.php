<?php

namespace App\Data\Category;

use App\Data\Dto;

class CategoryDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {}

    public static function from($model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            description: $model->description,
            created_at: $model->created_at->toIso8601String(),
            updated_at: $model->updated_at->toIso8601String(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
