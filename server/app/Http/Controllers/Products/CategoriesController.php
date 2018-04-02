<?php

namespace App\Http\Controllers\Products;

use App\Models\Product\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\Category as CategoryRequest;
use App\Http\Resources\Product\Product as ProductResource;
use App\Http\Resources\Product\Category as CategoryResource;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CategoriesController extends Controller
{
    /**
     * Display all categories.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $query = QueryBuilder::for(Category::class)->allowedFilters('name');

        return CategoryResource::collection($query->paginate());
    }

    /**
     * List all active categories.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list()
    {
        $query = QueryBuilder::for(Category::class)->allowedFilters('name')->active();

        return CategoryResource::collection($query->paginate());
    }

    /**
     * Store a newly created category.
     *
     * @param  CategoryRequest  $request
     * @return CategoryResource
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());

        if ($request->has('variants') && count($request->input('variants.*.id')) > 0) {
            $category->variants()->sync($request->input('variants.*.id'));
        }

        return new CategoryResource($category);
    }

    /**
     * Display the specified category.
     *
     * @param  Category  $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified category in storage.
     *
     * @param  Category         $category
     * @param  CategoryRequest  $request
     * @return CategoryResource
     */
    public function update(Category $category, CategoryRequest $request)
    {
        $category->update($request->all());

        if ($request->has('variants') && count($request->input('variants.*.id')) > 0) {
            $category->variants()->sync($request->input('variants.*.id'));
        }

        return new CategoryResource($category);
    }

    /**
     * Remove the specified category from storage.
     *
     * @throws \Exception
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response('oka');
    }
}
