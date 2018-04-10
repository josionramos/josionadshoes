<?php

namespace App\Http\Controllers\Products;

use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\Product as ProductRequest;
use App\Http\Resources\Product\Product as ProductResource;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProductsController extends Controller
{
    /**
     * Display all products.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $query = QueryBuilder::for(Product::class)->allowedFilters('category_id', 'featured');

        return ProductResource::collection($query->paginate());
    }

    /**
     * List products.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list()
    {
        \Log::debug('Products/list?includes');
        // DB::enableQueryLog();
        $query = QueryBuilder::for(Product::enable())->allowedFilters('category_id', 'featured')->enable();
        // dd($query);
        return ProductResource::collection($query->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest  $request
     * @return ProductResource
     */
    public function store(ProductRequest $request)
    {
        $fields = $request->all();
        $fields['slug'] = str_slug($request->title);

        $product = Product::create($fields);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product         $product
     * @param  ProductRequest  $request
     * @return ProductResource
     */
    public function update(Product $product, ProductRequest $request)
    {
        $product->update($request->all());

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Display related products.
     *
     * @param  Product  $product
     * @return ProductResource
     */
    public function related(Product $product, Request $request)
    {
        $query = Product::enable()
                        ->where('category_id', $product->category_id)
                        ->take($request->input('limit', 3));

        return ProductResource::collection($query->get());
    }

    /**
     * Show the specified resource by slug.
     *
     * @param  string  $slug
     * @return ProductResource
     */
    public function slug($slug)
    {
        $product = Product::enable()->where('slug', $slug)->firstOrFail();

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response('oka');
    }
}
