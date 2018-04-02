<?php

namespace App\PagSeguro\Resources;

use App\PagSeguro\Resource;

class Transaction extends Resource
{
    /**
     * Boleto.
     *
     * @var string
     */
    const BOLETO = 'boleto';

    /**
     * Credit card.
     *
     * @var string
     */
    const CREDIT_CARD = 'credit_card';

    /**
     * Transaction paid status id.
     *
     * @var int
     */
    const PAID = 3;

    /**
     * XML body.
     *
     * @var SimpleXMLElement
     */
    protected $root;

    /**
     * Items node.
     *
     * @var SimpleXMLElement
     */
    protected $items;

    /**
     * Sender node.
     *
     * @var SimpleXMLElement
     */
    protected $sender;

    /**
     * Shipping node.
     *
     * @var SimpleXMLElement
     */
    protected $shipping;

    /**
     * Credit card node.
     *
     * @var SimpleXMLElement
     */
    protected $creditCard;

    /**
     * Setup default body.
     *
     * @return void
     */
    protected function setup()
    {
        $root = new \SimpleXMLElement('<payment/>');
        $root->addChild('mode', 'default');
        $root->addChild('method', self::BOLETO);
        $root->addChild('currency', 'BRL');
        $root->addChild('receiverEmail', $this->client->getEmail());

        $this->root = $root;
    }

    /**
     * Set customer.
     *
     * @param  string  $name
     * @param  string  $email
     * @param  string  $cpf
     * @return Transaction
     */
    public function setCustomer($name, $email, $cpf)
    {
        if ($this->client->isSandbox()) {
            $email = preg_replace('/@\S+/', '@sandbox.pagseguro.com.br', $email);
        }

        $sender = $this->root->addChild('sender');
        $sender->addChild('name', $name);
        $sender->addChild('email', $email);

        $documents = $sender->addChild('documents');

        $cpfNode = $documents->addChild('document');
        $cpfNode->addChild('type', 'CPF');
        $cpfNode->addChild('value', preg_replace('/[^0-9]/', '', $cpf));

        $this->sender = $sender;

        return $this;
    }

    /**
     * Set customer and holder phone.
     *
     * @param  int  $ddd
     * @param  int  $number
     * @return Transaction
     */
    public function setPhone($ddd, $number)
    {
        $phone = $this->sender->addChild('phone');
        $phone->addChild('areaCode', preg_replace('/[^0-9]/', '', $ddd));
        $phone->addChild('number', preg_replace('/[^0-9]/', '', $number));

        return $this;
    }

    /**
     * Set hash.
     *
     * @param  string  $hash
     * @return Transaction
     */
    public function setHash($hash)
    {
        $this->sender->addChild('hash', $hash);

        return $this;
    }

    /**
     * Add item to transaction.
     *
     * @param  int     $id
     * @param  string  $description
     * @param  int     $amount
     * @param  int     $quantity
     * @return Transaction
     */
    public function addItem($id, $description, $amount, $quantity)
    {
        if (! $this->items) {
            $this->items = $this->root->addChild('items');
        }

        $item = $this->items->addChild('item');
        $item->addChild('id', $id);
        $item->addChild('description', $description);
        $item->addChild('amount', $amount);
        $item->addChild('quantity', $quantity);

        return $this;
    }

    /**
     * Set reference.
     *
     * @param  string  $reference
     * @return Transaction
     */
    public function setReference($reference)
    {
        $this->root->addChild('reference', $reference);

        return $this;
    }

    /**
     * Set shipping address.
     *
     * @param  string  $street
     * @param  string  $number
     * @param  string  $complement
     * @param  string  $district
     * @param  string  $city
     * @param  string  $uf
     * @param  string  $zipcode
     * @return Transaction
     */
    public function setAddress($street, $number, $complement, $district, $city, $uf, $zipcode)
    {
        if (! $this->shipping) {
            $this->shipping = $this->root->addChild('shipping');
        }

        $address = $this->shipping->addChild('address');
        $address->addChild('street', $street);
        $address->addChild('number', $number);
        $address->addChild('complement', $complement);
        $address->addChild('district', $district);
        $address->addChild('postalCode', $zipcode);
        $address->addChild('city', $city);
        $address->addChild('state', $uf);
        $address->addChild('country', 'BRL');

        return $this;
    }

    /**
     * Set shipping type and price.
     *
     * @param  int    $type
     * @param  float  $price
     * @return Transaction
     */
    public function setShipping($type, $price)
    {
        if (! $this->shipping) {
            $this->shipping = $this->root->addChild('shipping');
        }

        $this->shipping->addChild('type', $type);
        $this->shipping->addChild('cost', $price);

        return $this;
    }

    /**
     * Set credit card token.
     *
     * @param  string  $token
     * @return Transaction
     */
    public function setCreditCardToken($token)
    {
        if (! $this->creditCard) {
            $this->creditCard = $this->root->addChild('creditCard');
        }

        $this->root->method[0] = self::CREDIT_CARD;
        $this->creditCard->addChild('token', $token);

        return $this;
    }

    /**
     * Set installment.
     *
     * @param  int    $quantity
     * @param  float  $price
     * @param  int    $interestFree
     * @return Transaction
     */
    public function setInstallment($quantity, $price, $interestFree = 3)
    {
        if (!$this->creditCard) {
            $this->creditCard = $this->root->addChild('creditCard');
        }

        $installment = $this->creditCard->addChild('installment');
        $installment->addChild('value', $price);
        $installment->addChild('quantity', $quantity);
        $installment->addChild('noInterestInstallmentQuantity', $interestFree);

        return $this;
    }

    /**
     * Set credit card holder.
     *
     * @param  string  $name
     * @param  string  $cpf
     * @param  string  $birthdate
     * @return Transaction
     */
    public function setCreditCardHolder($name, $cpf, $birthdate)
    {
        if (! $this->creditCard) {
            $this->creditCard = $this->root->addChild('creditCard');
        }

        $holder = $this->creditCard->addChild('holder');
        $holder->addChild('name', $name);
        $holder->addChild('birthDate', $birthdate);

        $documents = $holder->addChild('documents');
        $document = $documents->addChild('document');
        $document->addChild('type', 'CPF');
        $document->addChild('value', preg_replace('/[^0-9]/', '', $cpf));

        return $this;
    }

    /**
     * Set billing adddress.
     *
     * @param  string  $street
     * @param  string  $number
     * @param  string  $complement
     * @param  string  $district
     * @param  string  $city
     * @param  string  $uf
     * @param  string  $zipcode
     * @return Transaction
     */
    public function setBillingAddress($street, $number, $complement, $district, $city, $uf, $zipcode)
    {
        if (! $this->creditCard) {
            $this->creditCard = $this->root->addChild('creditCard');
        }

        $address = $this->creditCard->addChild('billingAddress');
        $address->addChild('street', $street);
        $address->addChild('number', $number);
        $address->addChild('complement', $complement);
        $address->addChild('district', $district);
        $address->addChild('postalCode', $zipcode);
        $address->addChild('district', $district);
        $address->addChild('city', $city);
        $address->addChild('state', $uf);
        $address->addChild('country', 'BRL');

        return $this;
    }

    /**
     * Set credit card owner phone.
     *
     * @param  string $ddd
     * @param  string $number
     * @return Transaction
     */
    public function setCreditCardPhone($ddd, $number)
    {
        if (! $this->creditCard) {
            $this->creditCard = $this->root->addChild('creditCard');
        }

        $phone = $this->creditCard->addChild('phone');
        $phone->addChild('areaCode', $ddd);
        $phone->addChild('number', $number);

        return $this;
    }

    /**
     * Set payment method.
     *
     * @param  string $method
     * @return Transaction
     */
    public function setMethod($method)
    {
        $this->root->addChild('method', $method);

        return $this;
    }

    /**
     * Set Web Hook URL.
     *
     * @param  string $url
     * @return Transaction
     */
    public function setNotificationURL($url)
    {
        $this->root->addChild('notificationURL', $url);

        return $this;
    }

    /**
     * Create transaction.
     *
     * @return Response
     */
    public function create()
    {
        return $this->client->post('/v2/transactions', $this->root);
    }
}
