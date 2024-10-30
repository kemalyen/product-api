<?php

namespace App\Factories;

use App\Models\Product;

class ProductFactory
{
    public static function create(): Product
    {
        $product = new Product;
        $product->name = '';
        $product->sku = '';
        $product->barcode = '';
        $product->published_at = '';
        $product->description = '';
        $product->status = '';
        $product->quantity = '';
        $product->price = '';
        $product->category_id = '';
        return $product;
    }
 
}

