<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  new ProductCollection(
            Product::select(['id', 'name', 'sku', 'barcode', 'published_at', 'status'])
            ->paginate()
        );        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->options = $request->options;
        $product->published_at = $request->published_at;
        $product->status = $request->status;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();
        return  new ProductResource($product);
    }

    public function create_variant(Request $request, Product $product)
    {
        $varient_product = new Product();
        $varient_product->name = $request->name;
        $varient_product->sku = $request->sku;
        $varient_product->barcode = $request->barcode;
        $varient_product->options = $request->options;
        $varient_product->option_values = $request->option_values;
        $varient_product->published_at = $request->published_at;
        $varient_product->status = $request->status;
        $varient_product->quantity = $request->quantity;
        $varient_product->price = $request->price;
        
        $product->variants()->save($varient_product);
        return  (new ProductResource($varient_product))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return  new ProductResource($product);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->options = $request->options;
        $product->published_at = $request->published_at;
        $product->status = $request->status;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }

    public function variants(Product $product)
    {
        return  new ProductResource(
            $product->load('variants')
        );        

    }
}
