<?php

namespace App\Events\PagSeguro;

use App\Models\Payment\Payment;
use Illuminate\Http\Request;

class NotificationReceived
{
    /**
     * PagSeguro transaction.
     */
    // protected $transaction;

    /**
     * Constructor.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $api = app(\App\PagSeguro\Api::class);

        if ($request->input('notificationType') === 'transaction') {

            $response = $api->notification()->transaction($request->input('notificationCode'));

            $payment = Payment::where('reference', $response->reference)->first();
            $payment->events()->create([
                'status_id' => $response->status
            ]);

            if ($response->status == \App\PagSeguro\Resources\Transaction::PAID) {
                $payment->order()->update([
                    'status_id' => \App\PagSeguro\Resources\Transaction::PAID
                ]);
            }
        }
    }
}
