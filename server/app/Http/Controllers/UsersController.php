<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function me()
    {
        return auth()->user();
    }

    public function index()
    {
        $query = User::query();

        return UserResource::collection($query->paginate());
    }
}
