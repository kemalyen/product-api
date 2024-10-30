<?php

namespace App\Http\Controllers\Api;

use App\Factories\ProductFactory;
use App\Http\Controllers\ApiController;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
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
        $this->authorizeResource(Product::class);
    }

    /**
     * List all products
     * 
     * @group Product API Resource
     * @queryParam sort by product name, status, published date, created date and updated date
     * @queryParam filter[status] Filter by status: A,P,X
     * @queryParam filter[title] Filter by name. Wildcards are supported. Example: *fix*
     */
    public function index(ProductFilter $filter)
    {
        return ProductResource::collection(
            Product::filter($filter)->paginate()
        );
    }

    /**
     * Create a new product
     * 
     * @group Product API Resource
     *
     */
    public function store(ProductStoreRequest $request)
    {
        $product = $this->product_repository->save($request->validated(), ProductFactory::create());
        return new ProductResource($product);
    }

    /**
     * View a product
     * 
     * Display a individual product data.
     * 
     * @group Product API Resource
     * 
     */
    public function show(Product $product)
    {
        if ($this->include('category')) {
            return new ProductResource($product->load('category'));
        }

        return new ProductResource($product);
    }

    /**
     * Update a product
     * 
     * Update the specified product
     * 
     * @group Product API Resource
     * 
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product = $this->product_repository->update($request->all(), $product);
        return new ProductResource($product);
    }

    /**
     * Delete a product.
     * 
     * Remove the product resource
     * 
     * @group Product API Resource
     * 
     */
    public function destroy(Product $product)
    {
        $product->deleteOrFail();
    }
}
