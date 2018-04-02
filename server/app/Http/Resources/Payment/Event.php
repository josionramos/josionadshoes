<?php

namespace App\Http\Resources\Payment;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class Event extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status
        ];
    }
}
