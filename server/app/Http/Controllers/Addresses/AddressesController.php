<?php

namespace App\Http\Controllers\Addresses;

use App\Models\Address\State;
use App\Http\Controllers\Controller;
use App\Http\Resources\Address\City as CityResource;
use App\Http\Resources\Address\State as StateResource;

class AddressesController extends Controller
{
    public function states()
    {
        $query = State::orderBy('name')->get();

        return StateResource::collection($query);
    }

    public function cities(State $state)
    {
        return CityResource::collection($state->cities);
    }
}
