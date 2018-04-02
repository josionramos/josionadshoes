<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Media as MediaResource;
use App\Http\Resources\Product\Category as CategoryResource;

use Illuminate\Http\Resources\Json\Resource;

class Product extends Resource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => (int) $this->price,
            'category_id' => (int) $this->category_id,
            'price_sale' => (int) $this->price_sale,
            'featured' => (bool) $this->featured,
            'active' => (bool) $this->active,
            'content' => (string) $this->content,
            'cover' => new MediaResource($this->cover),

            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];

        if ($request->has('includes')) {
            $includes = explode(',', $request->includes);

            // SEO
            if (in_array('seo', $includes)) {
                $data['seo'] = [
                    'slug' => $this->slug,
                    'title' => $this->title,
                    'description' => $this->description
                ];
            }

            // Images
            if (in_array('images', $includes)) {
                $medias = [];

                foreach ($this->variants as $variant) {
                    \Log::debug('VARIANT MEDIA', [$variant->media]);
                    if ($variant->media) {
                        $medias[] = $variant->media;
                    }
                }

                \Log::debug('MEDIAS FROM VARIANTS', $medias);

                $data['images'] = MediaResource::collection($this->images->merge($medias));
            }

            // Variants
            if (in_array('variants', $includes)) {
                $data['variants'] = [];
                //Variants da categoria
                $variants = $this->category->variants;
                //echo "<script>console.log( 'BEGIN------GET variants includes------' );</script>";
                //echo "<script>console.log( 'Category size: " . $variants->count() . "' );</script>";
                \Log::debug('Category size', [$variants->count()]);
                if ($variants->count() > 0) {
                    //Category
                    foreach ($variants as $variant) {
                        $key = str_slug($variant->name, '_');
                        \Log::debug('Category name', [$key]);
                        //echo "<script>console.log( 'Category name: " . $key . "' );</script>";
                        $prod_variantes = $this->variants;
                        foreach ($prod_variantes as $prod_variant) {
                            //echo "<script>console.log( 'Category ID: " . $key . "' );</script>";
                            //echo "<script>console.log( 'Category ID from Prod: " . $prod_variant->type_id . "' );</script>";
                            \Log::debug('Category ID', [$variant->id]);
                            \Log::debug('Categoty from Prod ID', [$prod_variant->type_id]);
                            if ($variant->id == $prod_variant->type_id) {
                                $item = $prod_variant;
                                //echo "<script>console.log( 'Prod name: " . $prod_variant->value . "' );</script>";
                                \Log::debug('Prod item', [$item]);
                                if ($item) {
                                    $data['variants'][$key][] = new Variant($item);
                                }
                            }
                        }
                        //$item = $this->variants->where('type_id', $variant->id)->first();
                        //if ($item) {
                        //    $data['variants'][$key][] = new Variant($item);
                        //}
                    }
                }
                // echo "<script>console.log( 'END------GET variants includes------' );</script>";
                // $data['variants'] = Variant::collection($this->variants);
            }

            // Category
            if (in_array('category', $includes)) {
                $data['category'] = new CategoryResource($this->category);
            }

            // Shipping
            if (in_array('shipping', $includes)) {
                $data['shipping'] = [
                    'weight' => $this->weight,
                    'width' => $this->width,
                    'height' => $this->height,
                    'length' => $this->length
                ];
            }
        }

        return $data;
    }
}
