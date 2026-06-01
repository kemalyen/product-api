<?php

namespace App\Http\Controllers\Api;

use App\Data\Category\CategoryDto;
use App\Data\Common\PaginatedDto;
use App\Http\Controllers\ApiController;
use App\Http\Filters\CategoryFilter;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
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
    public function index(CategoryFilter $filter): JsonResponse
    {
        $categories = Category::filter($filter)->paginate();
        return response()->json(
            PaginatedDto::from($categories, fn($c) => CategoryDto::from($c))
        );
    }

    /**
     * Create a new category
     * 
     * @group Category API Resource
     *
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());
        return response()->json(CategoryDto::from($category), 201);
    }

    /**
     * View a category
     * 
     * Display a individual category data.
     * 
     * @group Category API Resource
     * 
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json(CategoryDto::from($category));
    }

    /**
     * Update a category
     * 
     * Update the specified category
     * 
     * @group Category API Resource
     * 
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $category->update($request->all());
        return response()->json(CategoryDto::from($category));
    }

    /**
     * Delete a category.
     * 
     * Remove the category resource
     * 
     * @group Category API Resource
     * 
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->deleteOrFail();
        return response()->json([], 204);
    }
}
