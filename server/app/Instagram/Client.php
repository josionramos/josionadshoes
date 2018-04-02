<?php

namespace App\Instagram;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Psr7\Request;

class Client
{
    const BASE_URL = 'https://api.instagram.com/v1/';

    protected $http;

    protected $token;

    public function __construct($token)
    {
        $this->http = new Http([
            'timeout' => 5.0,
            'base_uri' => self::BASE_URL,
        ]);

        $this->token = $token;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    protected function send($method, $url)
    {
        $query = [
            'access_token' => $this->token,
        ];

        $response = $this->http->request($method, trim($url, '/'), ['query' => $query]);

        return json_decode($response->getBody()->getContents());
    }

    public function get($url)
    {
        return $this->send('GET', $url);
    }
}
