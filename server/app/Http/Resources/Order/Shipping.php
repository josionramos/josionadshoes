<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Address\Address;
use Illuminate\Http\Resources\Json\Resource;

class Shipping extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'tracker' => $this->tracker,
            'address' => new Address($this->address)
        ];
    }
}
