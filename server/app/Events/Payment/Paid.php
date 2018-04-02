<?php

namespace App\Events\Payment;

use App\Mail\Order\Paid as OrderWasPaid;
use App\Models\Payment\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Paid
{
    /**
     * Current payment.
     *
     * @var Payment
     */
    protected $payment;

    /**
     * Constructor.
     *
     * @param  Payment  $payment
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;

        // Update Order status
        $payment->order()->update([
            'status_id' => 3
        ]);

        $this->sendMail();
    }

    /**
     * Send payment paid e-mail.
     */
    public function sendMail()
    {
        $order = $this->payment->order;

        Mail::to($order->customer->user->email)->send(new OrderWasPaid($order));
    }
}
