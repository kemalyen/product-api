<?php

namespace App\DTOs;

use App\Enums\ProductStatus;

class ProductDTO
{
    public function __construct(
        public string $sku,
        public string $barcode,
        public string $name,
        public ?string $description,
        public ?string $published_at,
        public ?string $status,
        public float $price,
        public ?int $stock = 0,

    ) {}

    /**
     * Create from CSV line data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            sku: $data[0] ?? '',
            barcode: $data[1] ?? '',
            name: $data[2] ?? '',
            description: self::normalizeDescription($data[3] ?? null),
            published_at: self::parseDate($data[4] ?? null),
            status: self::normalizeStatus($data[5] ?? null),
            price: self::normalizePrice((float)($data[6] ?? 0)),
            stock: self::normalizeStock(isset($data[7]) ? (int)$data[7] : null),
        );
    }

    private static function normalizeStatus(?string $status): ?string
    {
        return ProductStatus::tryFrom($status)?->value;
    }

    private static function parseDate(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        $timestamp = strtotime($date);
        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : null;
    }

    private static function normalizePrice(float $price): float
    {
        return round($price, 2);
    }

    private static function normalizeStock(?int $stock): int
    {
        return $stock ?? 0;
    }

    private static function normalizeDescription(?string $description): ?string
    {
        return $description ? trim($description) : null;
    }
}
