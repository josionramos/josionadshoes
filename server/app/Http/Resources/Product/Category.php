<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;

class Category extends Resource
{
    public function toArray($request)
    {
        $data = [
            'id' => (int) $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id ?? $this->parent_id,
            'active' => (bool) $this->active,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];

        if ($request->has('includes')) {
            $includes = explode(',', $request->includes);

            if (in_array('parent', $includes)) {
                $data['parent'] = $this->parent;
            }

            if (in_array('variants', $includes)) {
                $data['variants'] = VariantType::collection($this->variants);
            }
        }

        return $data;
    }
}
