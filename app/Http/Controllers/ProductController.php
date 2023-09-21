<?php

namespace App\Http\Controllers;

use App\Factories\ProductFactory;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductRepository $product_repository;

    public function __construct(ProductRepository $product_repository)
    {
        $this->product_repository = $product_repository;
    }
    
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
    public function store(ProductStoreRequest $request)
    {
        $product = $this->product_repository->save($request->all(), ProductFactory::create());
        return  new ProductResource($product);
    }

    public function create_variant(Request $request, Product $product)
    {
        $product = $this->product_repository->save($request->all(), ProductFactory::create($product->id));
        return  (new ProductResource($product))->response()->setStatusCode(201);
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
