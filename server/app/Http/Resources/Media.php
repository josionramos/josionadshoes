<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;

class Media extends Resource
{
    public function toArray($request)
    {
        $storage = Storage::disk('public');

        return [
            'id' => $this->id,
            'thumbnail' => $storage->url($this->thumbnail),
            'medium' => $storage->url($this->medium),
            'large' => $storage->url($this->large),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
