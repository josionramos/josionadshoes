<?php

namespace App\Http\Resources\Address;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class City extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'state' => new State($this->state),
        ];
    }
}
