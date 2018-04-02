<?php

namespace App\Correios\Shipping;

use Exception;
use DOMElement;
use DOMDocument;

class Response
{
    /**
     * XML Document from response.
     *
     * @var DOMDocument
     */
    protected $xml;

    /**
     * Constructor.
     *
     * @param  string $raw
     * @return void
     */
    public function __construct($raw)
    {
        $this->xml = new DOMDocument();
        $this->xml->loadXML($raw);
    }

    /**
     * Parse the response.
     *
     * @throws Exception
     * @return array
     */
    protected function parser()
    {
        $errors = $this->xml->getElementsByTagName('MsgErro');

        if (count($errors) > 0 && $errors[0]->nodeValue != '') {
            throw new Exception($errors[0]->nodeValue);
        }

        return $this->extract();
    }

    /**
     * Extract shipping data from response.
     *
     * @throws Exception
     * @return array
     */
    protected function extract()
    {
        $data = [];
        $services = $this->xml->getElementsByTagName('Servicos')[0];

        foreach ($services->childNodes as $service) {
            $price = $this->getValueFromService($service, 'Valor');
            $price = str_replace(',', '.', $price);

            $data[] = (object) [
                'code' => (int) $this->getValueFromService($service, 'Codigo'),
                'price' => (int) $price * 100,
                'time' => (int) $this->getValueFromService($service, 'PrazoEntrega')
            ];
        }

        return $data;
    }

    /**
     * Extract node value from service types.
     *
     * @param  DOMElement $element
     * @param  string $name
     * @return string
     */
    private function getValueFromService(DOMElement $element, $name)
    {
        return $element->getElementsByTagName($name)[0]->nodeValue;
    }

    /**
     * Get response content.
     *
     * @throws Exception
     * @return array
     */
    public function getContent()
    {
        return $this->parser();
    }
}
