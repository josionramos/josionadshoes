<?php

namespace App\PagSeguro\Resources;

use SimpleXMLElement;
use App\PagSeguro\Resource;

class Notification extends Resource
{
    /**
     * Start session.
     *
     * @return Response
     */
    public function transaction($code)
    {
        return $this->client->get('/v2/transactions/notifications/' . $code);
    }
}
