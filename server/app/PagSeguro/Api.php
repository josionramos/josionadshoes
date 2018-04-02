<?php

namespace App\PagSeguro;

class Api
{
    /**
     * Constructor.
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->client = new Client($config);
    }

    /**
     * Session endpoint.
     *
     * @return Resources\Session
     */
    public function session()
    {
        return new Resources\Session($this->client);
    }

    /**
     * Transaction endpoint.
     *
     * @return Resources\Session
     */
    public function transaction()
    {
        return new Resources\Transaction($this->client);
    }

    /**
     * Notification endpoint.
     *
     * @return Resources\Session
     */
    public function notification()
    {
        return new Resources\Notification($this->client);
    }
}
