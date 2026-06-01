<?php

namespace App\Http\Controllers\Api;

use App\Data\Common\PaginatedDto;
use App\Data\Product\ProductDto;
use App\Factories\ProductFactory;
use App\Http\Controllers\ApiController;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;

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
     * @queryParam filter[name] Filter by name. Wildcards are supported. Example: *fix*
     */
    public function index(ProductFilter $filter): JsonResponse
    {
        $cacheKey = 'product-filtering:' . md5(request()->fullUrl());

        $products = cache()->remember($cacheKey, now()->addMinutes(10), function () use ($filter) {
            return Product::with('product_prices')->filter($filter)->paginate();
        });

        return response()->json(
            PaginatedDto::from($products, fn($p) => ProductDto::from($p))
        );
    }

    /**
     * Create a new product
     * 
     * @group Product API Resource
     *
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $product = $this->product_repository->save($request->validated(), ProductFactory::create());
        return response()->json(ProductDto::from($product), 201);
    }

    /**
     * View a product
     * 
     * Display a individual product data.
     * 
     * @group Product API Resource
     * 
     */
    public function show(Product $product): JsonResponse
    {
        $cacheKey = 'product-view:' . $product->id;
        if ($this->include('category')) {
            $cacheKey .= ':with-category';
            $product = cache()->remember($cacheKey, now()->addMinutes(10), fn() => $product->load('category'));
        }

        $product = cache()->remember($cacheKey, now()->addMinutes(10), fn() => $product);
        return response()->json(ProductDto::from($product));
    }

    /**
     * Update a product
     * 
     * Update the specified product
     * 
     * @group Product API Resource
     * 
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $product = $this->product_repository->update($request->validated(), $product);
        return response()->json(ProductDto::from($product));
    }

    /**
     * Delete a product.
     * 
     * Remove the product resource
     * 
     * @group Product API Resource
     * 
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->deleteOrFail();
        return response()->json([], 204);
    }
}
