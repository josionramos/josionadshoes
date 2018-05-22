<?php

namespace App\Correios\Shipping;

use DOMDocument;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\RequestException;

use Illuminate\Support\Facades\Log;

class Client
{
    /**
     * Client URL.
     *
     * @var string
     */
    const URL = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';

    /**
     * HTTP Client.
     *
     * @var Http
     */
    protected $http;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->http = new Http([
            'timeout' => 30.0
        ]);
    }

    /**
     * Transform the raw response to Object.
     *
     * @return array
     */
    protected function response($raw)
    {
        $xml = new DOMDocument();
        $xml->loadXML($raw);

        $data = [];
        $services = $xml->getElementsByTagName('Servicos')[0];


        foreach ($services->childNodes as $service) {
            $price = $service->getElementsByTagName('Valor')[0]->nodeValue;
            $data[] = (object) [
                'price' => (float) str_replace(',', '.', $price),
                'time' => (int) $service->getElementsByTagName('PrazoEntrega')[0]->nodeValue
            ];
        }

        return $data;
    }

    /**
     * Send HTTP request to Correios.
     *
     * @param  array $data
     * @return Response
     */
    public function request(array $data)
    {
        $data['StrRetorno'] = 'xml';

//        try {
            $response = $this->http->request('GET',self::URL, [
                'query' => $data
            ]);
            
            Log::debug('Retorno API Correios: '.print_r($response,true));
//        } catch(RequestException $e) {
//            if ($e->hasResponse()) {
//                \Log::debug('STATUS: ' . $e->getResponse()->getStatusCode());
//                return response(':/', 503);
//            }
//
//            return response(':/', 503);
//        }

        return new Response($response->getBody()->getContents());
    }
}
