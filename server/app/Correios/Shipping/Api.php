<?php

namespace App\Correios\Shipping;

use Illuminate\Support\Facades\Log;

class Api
{
    /**
     * Correios PAC code.
     *
     * @var string
     */
    const PAC = '04510';

    /**
     * Correios PAC code.
     *
     * @var string
     */
    const SEDEX = '04014';

    /**
     * Package format.
     *
     * @var int
     */
    const FORMAT_PACKAGE = 1;

    /**
     * HTTP client.
     *
     * @var Client
     */
    protected $client;

    /**
     * API request body.
     *
     * @var array
     */
    protected $body = [];

    /**
     * Package items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Correios service types.
     *
     * @var array
     */
    protected $services = [];

    /**
     * Constructor.
     *
     * @param  Client  $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = new Client;

        // Defaults values
        $this->body = [
            'nCdEmpresa' => '',
            'sDsSenha' => '',
            'nCdFormato' => self::FORMAT_PACKAGE,
            'sCdMaoPropria' => 'N',
            'nVlValorDeclarado' => 0,
            'sCdAvisoRecebimento' => 'N',
        ];
    }

    /**
     * Where to shipping.
     *
     * @param  string $zipcode
     * @return Api
     */
    public function to($zipcode)
    {
        $this->body['sCepDestino'] = $this->clearZipcode($zipcode);
        \Log::debug('to zipcode : ', [strval($zipcode)]);
        return $this;
    }

    /**
     * From where.
     *
     * @param  string $zipcode
     * @return Api
     */
    public function from($zipcode)
    {
        $this->body['sCepOrigem'] = $this->clearZipcode($zipcode);
        \Log::debug('from zipcode : ', [strval($zipcode)]);
        return $this;
    }

    /**
     * Clear a zipcode string.
     *
     * @param  string $value
     * @return string
     */
    protected function clearZipcode($value)
    {
        return str_replace('-', '', $value);
    }

    /**
     * Add service type.
     *
     * @param  string $service
     * @return Api
     */
    public function addService($service)
    {
        $this->services[] = $service;

        return $this;
    }

    /**
     * Add a item to package.
     *
     * @param  int $width
     * @param  int $height
     * @param  int $length
     * @param  float $weight
     * @return Api
     */
    public function addItem($width, $height, $length, $weight, $qtd)
    {
        $this->items[] = [
          'width' => $width,
          'height' => $height,
          'length' => $length,
          'weight' => $weight,
          'qtd' => $qtd
        ];

        return $this;
    }

    /**
     * Stack items packaging.
     *
     * @return void
     */
    protected function stack()
    {
        $width = 0;
        $height = 0;
        $length = 0;
        $weight = 0;
        Log::debug('stack count : ', [strval(count($this->items))]);
        for ($i = 0; $i < count($this->items); $i++) {
            $item = $this->items[$i];

            $weight += floatval ($item['weight'] * $item['qtd']);

            if ($i == 0) {
                $width = $item['width'];
                $height = $item['height'];
                $length = $item['length'];
            } else {
                if ($item['width'] > $width) {
                    $width = $item['width'];
                }

                if ($item['length'] > $length) {
                    $length = $item['length'];
                }

                $height += $item['height'];
            }
        }
        Log::debug('stack largura : ', [strval($width)]);
        Log::debug('stack altura : ', [strval($height)]);
        Log::debug('stack comprimento : ', [strval($length)]);
        Log::debug('stack peso : ', [strval($weight)]);
        
        //Seta valores arbitrarios, deixa frete considerar apenas o peso
        $width = 30;
        $height = 20;
        $length = 30;
        
        $this->body['nVlLargura'] = $length;
        //$this->body['nVlLargura'] = $width;
        $this->body['nVlAltura'] = $height;
        $this->body['nVlComprimento'] = $width;
        //$this->body['nVlComprimento'] = $length;
        $this->body['nVlPeso'] = $weight;
    }

    /**
     * Calculate the shipping.
     *
     * @throws \Exception
     * @return Response
     */
    public function calc()
    {
        $this->stack();

        $this->body['nCdServico'] = implode(',', $this->services);

		$inicio = time();
        //Log::debug('Body: '.print_r($this->body,true));
		$_return = $this->client->request($this->body);
        $fim =  time();
		Log::debug('Consulta aos correios levou '.($fim - $inicio).' segundos');
        Log::debug('Correios/Api/calc/return: '.print_r($_return,true));
		
        return $_return;
    }
}
