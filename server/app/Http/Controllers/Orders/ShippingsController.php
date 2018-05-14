<?php

namespace App\Http\Controllers\Orders;

use App\Models\Order\Order;
use App\Mail\Order\Shipping;
use App\Correios\Shipping\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\Shipping as ShippingRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ShippingsController extends Controller
{
    /**
     * Auth customer.
     *
     * @var \App\Customer
     */
    protected $customer;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->customer = auth()->user()->customer;

            return $next($request);
        });
    }

    /**
     * Calculate shipping price.
     *
     * @throws \Exception
     * @param  int              $orderId
     * @param  ShippingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function calc(Api $api, $orderId, ShippingRequest $request)
    {
        $order = $this->customer->orders()->findOrFail($orderId);
        $address = $this->customer->addresses()->findOrFail($request->address_id);

        $api->to($address->zipcode)
            ->from('95680000')
            ->addService(Api::PAC)
            ->addService(Api::SEDEX);

        foreach ($order->items as $item) {
            $product = $item->product;

            $api->addItem(
                $product->width,
                $product->height,
                $product->length,
                number_format($product->weight / 1000, 2)
            );
        }

        try {
            $response = $api->calc();
        } catch (\Exception $e) {
            return response($e->getMessage(), 503);
        }

        return response()->json($response->getContent());
    }

    /**
     * Add tracker on order shipping.
     *
     * @param  Order   $order
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function tracker(Order $order, Request $request)
    {
        $order->update([
            'status_id' => 4
        ]);

        $order->shipping()->update([
            'tracker' => $request->tracker
        ]);

        Mail::to($order->customer->user->email)->send(new Shipping($order));

        return 'okay ;)';
    }
}
