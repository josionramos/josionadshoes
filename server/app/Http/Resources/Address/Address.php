<?php

namespace App\Http\Resources\Address;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class Address extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'zipcode' => $this->zipcode,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement,
            'district' => $this->district,
            'city_id' => $this->city_id,
            'city' => new City($this->city),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
