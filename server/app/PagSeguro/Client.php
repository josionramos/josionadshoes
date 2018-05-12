<?php

namespace App\PagSeguro;

use SimpleXMLElement;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\ClientException;

class Client
{
    /**
     * Client base URL.
     *
     * @var string
     */
    const BASE_URL = 'https://ws.pagseguro.uol.com.br';

    /**
     * HTTP Client.
     *
     * @var Http
     */
    protected $http;

    /**
     * Client token.
     *
     * @var string
     */
    protected $token;

    /**
     * Client e-mail.
     *
     * @var string
     */
    protected $email;

    /**
     * Client environment.
     *
     * @var string
     */
    protected $env;

    /**
     * Construct.
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->env = $config['env'];
        $this->token = $config['token'];
        $this->email = $config['email'];

        $this->setupHttp();
    }

    /**
     * Get auth e-mail.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Check if is sandbox environment.
     *
     * @return boolean
     */
    public function isSandbox()
    {
        return $this->env == 'sandbox';
    }

    /**
     * Setup HTTP client.
     *
     * @return void
     */
    protected function setupHttp()
    {
        $url = self::BASE_URL;

        // Set URL for SANDBOX
        if ($this->isSandbox()) {
            $url = str_replace('ws.', 'ws.sandbox.', $url);
        }

        $this->http = new Http([
            'timeout' => 300.0,
            'base_uri' => $url,
            'headers' => [
                'Content-Type' => 'application/xml;chartset=UTF-8'
            ]
        ]);
    }

    /**
     * Send HTTP request.
     *
     * @param  Request $request
     * @return Response
     */
    protected function send(Request $request)
    {
        // \Log::debug('REQUEST', [
        //     'METHOD' => $request->getMethod(),
        //     'URL' => $request->getUri()->getPath(),
        //     'BODY' => $request->getBody()->getContents()
        // ]);

        try {
            $response = $this->http->send($request, [
                'query' => [
                    'email' => $this->email,
                    'token' => $this->token
                ]
            ]);
        } catch (ClientException $e) {
            throw new Exceptions\RequestException($e);
        }

        return new Response($response);
    }

    /**
     * Send GET HTTP request
     *
     * @param  string $uri
     * @return Response
     */
    public function get($uri)
    {
        return $this->send(new Request('GET', $uri));
    }

    /**
     * Send POST HTTP request
     *
     * @param  string  $uri
     * @return Response
     */
    public function post($uri, SimpleXMLElement $xml)
    {
        return $this->send(new Request('POST', $uri, [], $xml->asXML()));
    }
}
