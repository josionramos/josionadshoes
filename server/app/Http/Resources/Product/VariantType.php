<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;

class VariantType extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
