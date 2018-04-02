<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\Variant;
use Illuminate\Http\Resources\Json\Resource;

class Item extends Resource
{
    public function toArray($request)
    {
        $data =  [
            'id' => $this->id,
            'total' => $this->total,
            'price' => $this->price,
            'amount' => $this->amount,
            'product' => new Product($this->product),
            'variants' => Variant::collection($this->variants),
        ];

        if ($request->has('includes')) {
            $includes = explode(',', $request->includes);

            // Variants
            if (in_array('variants', $includes)) {
                $data['variants'] = Variant::collection($this->variants);
            }
        }

        return $data;
    }
}
