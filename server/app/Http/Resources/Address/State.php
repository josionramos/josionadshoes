<?php

namespace App\Http\Resources\Address;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class State extends Resource
{
    public function toArray($request)
    {
        return [
            'uf' => $this->uf,
            'name' => $this->name
        ];
    }
}
