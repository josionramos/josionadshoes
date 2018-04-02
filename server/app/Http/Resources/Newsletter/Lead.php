<?php

namespace App\Http\Resources\Newsletter;

use Illuminate\Http\Resources\Json\Resource;

class Lead extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token,
            'active' => (bool) $this->active,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
