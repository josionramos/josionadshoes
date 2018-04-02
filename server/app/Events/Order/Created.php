<?php

namespace App\Events\Order;

use App\Models\Order\Order;
use App\Models\Order\Status;
use App\Mail\Order\Created as OrderWasCreated;

use Illuminate\Support\Facades\Mail;

class Created
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

        $this->sendMail();
    }

    /**
     * Send customer e-mail with created order.
     *
     * @return void
     */
    protected function sendMail()
    {
        Mail::to($this->order->customer->user->email)->send(new OrderWasCreated($this->order));
    }
}
