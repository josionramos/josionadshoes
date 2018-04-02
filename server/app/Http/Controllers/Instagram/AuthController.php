<?php

namespace App\Http\Controllers\Instagram;

use App\Instagram\Api;
use App\Models\Instagram\Instagram;
use App\Http\Controllers\Controller;

use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::with('instagram')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::with('instagram')->user();

        Instagram::create([
            'name' => $user->name,
            'nickname' => $user->nickname,
            'avatar' => $user->avatar,
            'token' => $user->token,
            'account_id' => $user->id,
        ]);

        dd($user);
    }
}
