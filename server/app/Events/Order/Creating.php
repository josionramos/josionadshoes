<?php

namespace App\Events\Order;

use App\Models\Order\Order;
use App\Models\Order\Status;

class Creating
{
    /**
     * Creating order.
     *
     * @var Order
     */
    protected $order;

    /**
     * Constructor.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;

        $this->setStartedStatus();
        $this->generateReference();
    }

    /**
     * Generate order reference code.
     *
     * @return void
     */
    protected function generateReference()
    {
        $random = strtoupper(str_random(4));
        $reference = date('ymd') . $random . date('His');

        $this->order->reference = $reference;
    }

    /**
     * Set started status.
     *
     * @return void
     */
    protected function setStartedStatus()
    {
        $this->order->status_id = Status::STARTED;
    }
}
