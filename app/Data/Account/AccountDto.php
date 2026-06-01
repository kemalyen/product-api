<?php

namespace App\Data\Account;

use App\Data\Dto;

class AccountDto extends Dto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $account_number,
        public readonly string $status,
        public readonly string $plan_tier,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {}

    public static function from($model): self
    {
        return new self(
            id: $model->id,
            name: $model->name,
            account_number: $model->account_number,
            status: $model->status,
            plan_tier: $model->plan_tier ?? 'free',
            created_at: $model->created_at->toIso8601String(),
            updated_at: $model->updated_at->toIso8601String(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'account_number' => $this->account_number,
            'status' => $this->status,
            'plan_tier' => $this->plan_tier,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
