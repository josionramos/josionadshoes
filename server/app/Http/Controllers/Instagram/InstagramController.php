<?php

namespace App\Http\Controllers\Instagram;

use App\Instagram\Api;
use App\Models\Instagram\Instagram;
use App\Http\Controllers\Controller;

class InstagramController extends Controller
{
    public function recent()
    {
        $account = Instagram::findOrFail(1);
        $api = new Api($account->token);

        $posts = $api->getMostRecentMedia()->data;

        return response($posts);
    }
}
