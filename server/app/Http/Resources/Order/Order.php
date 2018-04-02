<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Customer;
use App\Http\Resources\Payment\Payment;
use Illuminate\Http\Resources\Json\Resource;

class Order extends Resource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'reference' => $this->reference,
            'status_id' => $this->status_id,
            'customer_id' => $this->customer_id,
            'shipping_id' => $this->shipping_id,
            'total' => $this->total,
            'subTotal' => $this->subTotal,
            'created_at' => (string) $this->created_at
        ];

        if ($request->has('includes')) {
            $includes = explode(',', $request->includes);

            // Shipping
            if (in_array('shipping', $includes)) {
                $data['shipping'] = new Shipping($this->shipping);
            }

            // Status
            if (in_array('status', $includes)) {
                $data['status'] = new Status($this->status);
            }

            // Items
            if (in_array('items', $includes)) {
                $data['items'] = Item::collection($this->items);
            }

            // Customer
            if (in_array('customer', $includes)) {
                $data['customer'] = new Customer($this->customer);
            }

            // Payment
            if (in_array('payment', $includes)) {
                $data['payment'] = new Payment($this->payment);
            }
        }

        return $data;
    }
}
