<?php

namespace App\Http\Controllers\Orders;

use App\Models\Order\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\Item as ItemResource;

use Spatie\QueryBuilder\QueryBuilder;

class ItemsController extends Controller
{
    /**
     * Display items from a orders.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Order $order)
    {
        $query = QueryBuilder::for($order->items()->getQuery());

        return ItemResource::collection($query->paginate());
    }
}
