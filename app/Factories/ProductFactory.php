<?php

namespace App\Factories;

use App\Models\Product;

class ProductFactory
{
    public static function create(int $parent_id = 0): Product
    {
        $product = new Product;
        $product->name = '';
        $product->parent_id = $parent_id;
        $product->sku = '';
        $product->barcode = '';
        $product->options = [];
        $product->option_values = [];
        $product->published_at = '';
        $product->status = '';
        $product->quantity = '';
        $product->price = '';
        return $product;
    }
}
