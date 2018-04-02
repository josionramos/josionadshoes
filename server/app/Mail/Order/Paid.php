<?php

namespace App\Mail\Order;

use App\Models\Order\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Paid extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Current order.
     *
     * @var Order
     */
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order.paid')->with([
            'order' => $this->order
        ])->subject('Pagamento recebido');
    }
}
