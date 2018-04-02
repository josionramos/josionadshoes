<?php

namespace App\PagSeguro;

use SimpleXMLElement;
use GuzzleHttp\Psr7\Response as HttpResponse;

class Response
{
    /**
     * Raw response.
     *
     * @var string
     */
    protected $raw;

    /**
     * Response body.
     *
     * @var SimpleXMLElement
     */
    protected $body;

    /**
     * HTTP Reponse.
     *
     * @var HttpResponse
     */
    protected $response;

    /**
     * Constructor.
     *
     * @param  HttpResponse  $response
     * @return void
     */
    public function __construct(HttpResponse $response)
    {
        $this->parser($response);
    }

    /**
     * Parser response.
     *
     * @param  HttpResponse  $response
     * @return void
     */
    protected function parser(HttpResponse $response)
    {
        $this->response = $response;
        $this->raw = $response->getBody()->getContents();

        try {
            $this->body = new SimpleXMLElement($this->raw);
        } catch (\Exception $e) {
            $this->body = $this->raw;
        }
    }

    /**
     * Get response raw content.
     *
     * @return string
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * Get response status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    public function xml()
    {
        return $this->body;
    }

    /**
     * Get property from body
     *
     * @param  string  $name
     * @return string|null
     */
    public function __get($name)
    {
        return $this->body->{$name};
    }

    /**
     * Response to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getRaw();
    }
}
