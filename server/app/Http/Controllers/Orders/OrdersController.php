<?php

namespace App\Http\Controllers\Orders;

use App\Models\Order\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\Order as OrderResource;

use Spatie\QueryBuilder\QueryBuilder;

class OrdersController extends Controller
{
    /**
     * Display all orders.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $query = QueryBuilder::for(Order::class)->allowedFilters('customer_id', 'status_id', 'reference');

        return OrderResource::collection($query->paginate());
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
