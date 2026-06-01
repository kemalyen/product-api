<?php

namespace App\Data\Common;

use App\Data\Dto;

class PaginatedDto extends Dto
{
    public function __construct(
        public readonly array $data,
        public readonly int $total,
        public readonly int $per_page,
        public readonly int $current_page,
        public readonly int $last_page,
    ) {}

    public static function from($paginator, $transform = null): self
    {
        $data = $paginator->items();
        if ($transform) {
            $data = array_map($transform, $data);
        }

        return new self(
            data: $data,
            total: $paginator->total(),
            per_page: $paginator->perPage(),
            current_page: $paginator->currentPage(),
            last_page: $paginator->lastPage(),
        );
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'meta' => [
                'total' => $this->total,
                'per_page' => $this->per_page,
                'current_page' => $this->current_page,
                'last_page' => $this->last_page,
            ],
        ];
    }
}
