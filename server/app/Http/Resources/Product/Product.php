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
                $variants = $this->category->variants;

                if ($variants->count() > 0) {
                    foreach ($variants as $variant) {
                        $key = str_slug($variant->name, '_');
                        $item = $this->variants->where('type_id', $variant->id)->first();

                        if ($item) {
                            $data['variants'][$key][] = new Variant($item);
                        }
                    }
                }

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
