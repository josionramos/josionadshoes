<?php

namespace App\Instagram;

class Api
{
    protected $client;

    public function __construct($token)
    {
        $this->client = new Client($token);
    }

    public function getMostRecentMedia()
    {
        return $this->client->get('/users/self/media/recent');
    }
}
