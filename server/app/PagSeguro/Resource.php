<?php

namespace App\PagSeguro;

class Resource
{
    /**
     * HTTP Client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Constructor.
     *
     * @param  Client  $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->setup();
    }

    protected function setup()
    {
        //
    }
}
