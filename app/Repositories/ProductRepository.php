<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function save(array $data, Product $product) : ?Product
    {
        $product->fill($data);
        $product->save();
        return $product;
    }

    
    public function update(array $data, Product $product) : ?Product
    {
        $product->update($data);
        return $product;
    }
}