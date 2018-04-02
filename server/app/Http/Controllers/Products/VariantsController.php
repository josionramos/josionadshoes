<?php

namespace App\Http\Controllers\Products;

use App\Models\Product\Product;
use App\Models\Product\Variant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\Media as MediaRequest;
use App\Http\Requests\Product\Variant as VariantRequest;
use App\Http\Resources\Product\Variant as VariantResource;

class VariantsController extends Controller
{
    /**
     * List all product variants.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Product $product)
    {
        return VariantResource::collection($product->variants);
    }

    /**
     * Store a product variant.
     *
     * @param  Product         $product
     * @param  VariantRequest  $request
     * @return VariantResource
     */
    public function store(Product $product, VariantRequest $request)
    {
        $variant = $product->variants()->create($request->all());

        return new VariantResource($variant);
    }

    public function update(Product $product, Variant $variant, VariantRequest $request)
    {
        $variant = $product->variants()->findOrFail($variant->id);
        $variant->update($request->all());

        return response('oka');
    }

    /**
     * Delete a product variant.
     *
     * @throws \Exception
     * @param  Product  $product
     * @param  Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Variant $variant)
    {
        $variant = $product->variants()->findOrFail($variant->id);
        $variant->delete();

        return response('oka');
    }
}
