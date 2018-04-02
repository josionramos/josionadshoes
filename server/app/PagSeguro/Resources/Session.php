<?php

namespace App\PagSeguro\Resources;

use SimpleXMLElement;
use App\PagSeguro\Resource;

class Session extends Resource
{
    /**
     * Start session.
     *
     * @return Response
     */
    public function start()
    {
        return $this->client->post('/v2/sessions', new SimpleXMLElement('<session/>'));
    }
}
