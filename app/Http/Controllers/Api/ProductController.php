<?php

namespace App\Http\Controllers\Api;

use App\Factories\ProductFactory;
use App\Http\Controllers\ApiController;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;


class ProductController extends ApiController
{
    protected ProductRepository $product_repository;

    public function __construct(ProductRepository $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function index(ProductFilter $filter)
    {
        return ProductResource::collection(
            Product::filter($filter)->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $product = $this->product_repository->save($request->all(), ProductFactory::create());
        return new ProductResource($product);
    }
 
    public function show(Product $product)
    {
        if ($this->include('category')) {
            return new ProductResource($product->load('category'));
        }

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product = $this->product_repository->update($request->all(), $product);
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->deleteOrFail();
    }
}
