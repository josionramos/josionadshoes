<?php

namespace App\Http\Resources\Payment;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class Payment extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'tax' => $this->tax,
            'reference' => $this->reference,
            'type' => $this->type,
            'events' => Event::collection($this->events)
        ];
    }
}
