<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Filters\CategoryFilter;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{

    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }
    
    /**
     * List all categories
     * 
     * @group Category API Resource
     * @queryParam sort by category name
     * @queryParam filter[title] Filter by name. Wildcards are supported. Example: *fix*
     */
    public function index(CategoryFilter $filter)
    {
        return CategoryResource::collection(
            Category::filter($filter)->paginate()
        );
    }

    /**
     * Create a new category
     * 
     * @group Category API Resource
     * 
     * @response 201 { {
    "data": {
        "type": "category",
        "id": 5,
        "attributes": {
            "name": "A test category"
        }
    }
}}
     *
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->all());
        return new CategoryResource($category);
    }

    /**
     * View a category
     * 
     * Display a individual category data.
     * 
     * @group Category API Resource
     * 
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update a category
     * 
     * Update the specified category
     * 
     * @group Category API Resource
     * 
     */
    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return new CategoryResource($category);
    }

    /**
     * Delete a category.
     * 
     * Remove the category resource
     * 
     * @group Category API Resource
     * 
     */
    public function destroy(Category $category)
    {
        $category->deleteOrFail();
    }
}
