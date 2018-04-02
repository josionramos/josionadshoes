<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Media;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class Product extends Resource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name
        ];

        if ($this->cover) {
            $data['thumbnail'] = Storage::disk('public')->url($this->cover->thumbnail);
        }

        return $data;
    }
}
