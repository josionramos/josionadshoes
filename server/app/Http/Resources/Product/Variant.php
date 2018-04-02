<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Media as MediaResource;
use App\Http\Resources\Product\Product as ProductResource;
use App\Http\Resources\Product\VariantType as TypeResource;

use Illuminate\Http\Resources\Json\Resource;

class Variant extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'value' => $this->value,
            'extra' => $this->extra,
            'active' => (bool) $this->active,
            'type_id' => $this->type_id,
            'media_id' => $this->media_id,
            'product_id' => $this->product_id,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,

            // Relations
            'type' => new TypeResource($this->type),
            'media' => new MediaResource($this->media),
        ];
    }
}
