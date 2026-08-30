<?php

namespace App\Http\Filters;

class ProductFilter extends QueryFilter
{
    protected $sortable = [
        'name',
        'status',
        'publishedAt' => 'published_at',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];

    public function createdAt(string $value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

    public function include(string $value)
    {
        return $this->builder->with($value);
    }

    public function status(string $value)
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }

    public function name(string $value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $likeStr);
    }

    public function sku(string $value)
    {
        return $this->builder->whereIn('sku', explode(',', $value));
    }


    public function barcode(string $value)
    {
        return $this->builder->whereIn('barcode', explode(',', $value));
    }

    public function stock(string $value)
    {
        $operator = '=';
        $stock = $value;

        if (preg_match('/^(<|>|>=|<=|=)(.+)$/', $value, $matches)) {
            $operator = $matches[1];
            $stock = $matches[2];
        }

        return $this->builder->where('stock', $operator, $stock);
    }

    public function price(string $value)
    {
        $operator = '=';
        $price = $value;

        if (preg_match('/^(<|>|>=|<=|=)(.+)$/', $value, $matches)) {
            $operator = $matches[1];
            $price = $matches[2];
        }

        return $this->builder->where('price', $operator, $price);
    }


    public function updatedAt($value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }
}
