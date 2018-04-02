<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\Resource;

class Status extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
