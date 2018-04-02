<?php

namespace App\Http\Controllers\Products;

use App\Models\Media;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\Media as MediaResource;
use App\Http\Requests\Product\Media as MediaRequest;

class MediaController extends Controller
{
    /**
     * Update product media cover
     *
     * @param  Product  $product
     * @param  MediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function cover(Product $product, MediaRequest $request)
    {
        $product->media_id = $request->id;
        $product->save();

        return response('oka');
    }

    /**
     * Attach media to a product.
     *
     * @param  Product       $product
     * @param  MediaRequest  $request
     * @return MediaResource
     */
    public function store(Product $product, MediaRequest $request)
    {
        $media = Media::findOrFail($request->id);

        $product->images()->attach($media->id);

        return new MediaResource($media);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, MediaRequest $request)
    {
        $media = $product->images()->find($request->id);

        $product->images()->detach($media->id);
        $media->delete();

        return response('oka');
    }
}
