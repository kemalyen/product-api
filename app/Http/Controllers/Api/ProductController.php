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
     * @queryParam filter[status] Filter by status: active,inactive,pending
     * @queryParam filter[sku] Filter by sku: 45117459,74569441
     * @queryParam filter[name] Filter by name. Wildcards are supported. Example: *fix*
     */
    public function index(ProductFilter $filter): JsonResponse
    {

        $userId = request()->user() ? request()->user()->id : 'guest';
        $cacheKey = 'product-filtering:' . md5(request()->fullUrl()) . ':user-id:' . $userId;

        $products = cache()->tags(['products'])->remember($cacheKey, now()->addMinutes(10), function () use ($filter) {
            return ProductResource::collection(
                Product::with('product_prices')->filter($filter)->paginate()
            )->response()->getData(true);
        });

        return response()->json($products);
    }

    /**
     * Create a new product
     * 
     * @group Product API Resource
     *
     */
    public function store(ProductStoreRequest $request): ProductResource
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
    public function show(Product $product): ProductResource
    {
        $userId = request()->user() ? request()->user()->id : 'guest';
        $cacheKey = 'product-show:' . $product->id . ':' . md5(request()->fullUrl()) . ':user-id:' . $userId;
        if ($this->include('category')) {
            $cacheKey .= ':with-category';
        }

        return cache()->tags(['products'])->remember($cacheKey, now()->addMinutes(10), function () use ($product) {
            if ($this->include('category')) {
                $product->load('category');
            }
            return new ProductResource($product);
        });
    }

    /**
     * Update a product
     * 
     * Update the specified product
     * 
     * @group Product API Resource
     * 
     */
    public function update(ProductUpdateRequest $request, Product $product): ProductResource
    {
        $product = $this->product_repository->update($request->validated(), $product);
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
    public function destroy(Product $product): JsonResponse
    {
        $product->deleteOrFail();
        return response()->json([], 204);
    }
}
