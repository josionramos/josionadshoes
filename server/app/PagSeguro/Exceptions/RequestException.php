<?php

namespace App\PagSeguro\Exceptions;

use App\PagSeguro\Response;
use GuzzleHttp\Exception\ClientException;

class RequestException extends \Exception
{
    protected $response;

    public function __construct(ClientException $prev)
    {
        $this->response = new Response($prev->getResponse());

        parent::__construct(
            'Invalid request PagSeguro',
            $prev->getResponse()->getStatusCode(),
            $prev
        );
    }

    /**
     * Get HTTP response.
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get response errors.
     *
     * @return array
     */
    public function getErrors()
    {
        $errors = [
            'errors' => [],
            'message' => 'PagSeguro Bad Request'
        ];

        foreach ($this->response->xml()->children() as $error) {
            $errors['errors'][(string) $error->code] = (string) $error->message;
        }

        return $errors;
    }
}
