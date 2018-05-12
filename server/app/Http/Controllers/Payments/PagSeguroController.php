<?php

namespace App\Http\Controllers\Payments;

use App\PagSeguro\Api;
use App\PagSeguro\Resources\Transaction;
use App\PagSeguro\Exceptions\RequestException;

use App\Events\Order\Created;
use App\Events\Payment\Paid;
use App\Models\Payment\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PagSeguro as PagSeguroRequest;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use Exception;

class PagSeguroController extends Controller
{
    /**
     * Start PagSeguro session.
     *
     * @param  Api $api
     * @return \Illuminate\Http\Response
     */
    public function session(Api $api)
    {
        return response([
            'id' => (string) $api->session()->start()->id
        ], 200);
    }

    /**
     * Process a PagSeguro transaction.
     *
     * @param  Api              $api
     * @param  PagSeguroRequest $request
     * @return void
     */
    public function process(Api $api, PagSeguroRequest $request)
    {
        $reference = date('ymd') . strtoupper(str_random(5)) . date('his');

        // 1) Get customer order
        $user = auth()->user();
        $customer = $user->customer;
//	Log::info('Customer: '.$customer);
        $order = $customer->orders()->findOrFail($request->order_id);

        $phone = explode(' ', $customer->phone);

        Log::info('Phone: '.print_r($phone,true));
        // 2) Create shipping
        $shipping = $order->shipping()->create($request->input('shipping'));
        $address = $shipping->address;

        // 3) Setup common data for PagSeguro
        $transaction = $api->transaction();
        $transaction->setCustomer($user->name, $user->email, $customer->cpf)
                    ->setHash($request->input('hash'))
                    ->setPhone($phone[0],$phone[1])
                    ->setAddress(
                        $address->street,
                        $address->number,
                        $address->complement,
                        $address->district,
                        $address->city->name,
                        $address->city->state->uf,
                        $address->zipcode
                    )
                    ->setShipping('PAC', number_format($shipping->price / 100, 2))
                    ->setReference($reference)
                    ->setNotificationUrl(config('pagseguro.webhook'));

        // 4) Add items to transaction
        foreach ($order->items as $item) {
            $product = $item->product;
            $transaction->addItem(
                $product->id,
                str_limit($product->description, 90),
                number_format($item->total / 100, 2),
                $item->amount
            );
        }

        // 5) Complete API for each payment type
        if ($request->method === 'credit_card') {
            $transaction->setCreditCardToken($request->input('creditCard.token'));

            $transaction->setBillingAddress(
                $address->street,
                $address->number,
                $address->complement,
                $address->district,
                $address->city->name,
                $address->city->state->uf,
                $address->zipcode
            );

            $transaction->setInstallment(
                $request->input('creditCard.installment.amount'),
                number_format($request->input('creditCard.installment.price'), 2)
            );

            if (! $request->input('creditCard.owner')) {

                $phone = explode(' ', $request->input('creditCard.holder.phone'));

                $transaction->setCreditCardHolder(
                    $request->input('creditCard.holder.name'),
                    $request->input('creditCard.holder.cpf'),
                    $request->input('creditCard.holder.birthdate'),
                    $phone[0],
                    $phone[1]
                );

                $transaction->setCreditCardPhone($phone[0], $phone[1]);

            } else {

                Log::info('Customer: '.print_r($customer,true));

                $transaction->setCreditCardHolder(
                    $user->name,
                    $customer->cpf,
                    date("d/m/Y", strtotime($customer->birthdate)),
                    $phone[0],
                    $phone[1]
                );

                $transaction->setCreditCardPhone($phone[0], $phone[1]);
            }
        }

        // 6) Send request to PagSeguro
        try {
            Log::info('Transaction: '.print_r($transaction,true));
			//$error = 'Sistema em teste!';
			//throw new Exception($error);
            $response = $transaction->create();
        } catch (RequestException $e) {
            return response($e->getErrors(), 422);
        }

        // 7) Create payment model
        $order->payment()->create([
            'tax' => (int)$response->feeAmount * 100,
            'price' => (int)$response->netAmount * 100,
            'reference' => $reference,
            'type_id' => 1,
            'gateway_id' => 1
        ]);

        // 8) Fire a event for notification payment
        event(new Created($order));

        return [
            'link' => (string) $response->paymentLink,
            'order' => $order
        ];
    }

    /**
     * Receive PagSeguro webhook.
     *
     * @param  Api     $api
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function webhook(Api $api, Request $request)
    {
        // Allow only PagSeguro requests
        if (config('pagseguro.env') != 'sandbox' && $request->getHttpHost() != 'ws.pagseguro.uol.com.br') {
            return response('Unauthorized', 401);
        }

        if ($request->input('notificationType') === 'transaction') {

            $response = $api->notification()->transaction($request->notificationCode);

            $payment = Payment::where('reference', $response->reference)->firstOrFail();
            $payment->events()->create([
                'status_id' => $response->status
            ]);

            // Payment was paid.
            if ($response->status == Transaction::PAID) {
                event(new Paid($payment));
            }
        }

        return response('Obrigado PagSeguro!', 200);
    }
}
