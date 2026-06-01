<?php

namespace App\Data\User;

use App\Data\Dto;

class UserDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $role = null,
        public readonly string $created_at = '',
    ) {}

    public static function from($model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            role: $model->roles?->first()?->name,
            created_at: $model->created_at->toIso8601String(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'created_at' => $this->created_at,
        ];
    }
}
