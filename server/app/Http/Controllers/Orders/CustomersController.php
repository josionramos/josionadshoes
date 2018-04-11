<?php

namespace App\Http\Controllers\Orders;

use App\Models\Order\Order;
use App\Models\Product\Variant as ProductVariant;
use App\Models\Product\Product as Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\Item as ItemRequest;
use App\Http\Requests\Order\Order as OrderRequest;
use App\Http\Resources\Order\Item as ItemResource;
use App\Http\Resources\Order\Order as OrderResource;

class CustomersController extends Controller
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
     * List all orders from customer.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $query = $this->customer->orders()->hasPayment();

        return OrderResource::collection($query->paginate());
    }

    /**
     * Create a new order.
     *
     * @param  OrderRequest  $request
     * @return OrderResource
     */
    public function store(OrderRequest $request)
    {
        // 1. Create the order
        $order = $this->customer->orders()->create([]);
        \Log::debug('customers/me/orders store 0: ', [$order]);
        // For each items
        $items = [];

        foreach ($request->input('items') as $key => $item) {
            $productId = $item['product_id'];
            \Log::debug('customers/me/orders store 1: ', [$productId]);

            $variantIds = $request->input("items.{$key}.variants.*.id");
            \Log::debug('customers/me/orders store 2: ', [$variantIds]);

            // Need to add call to check with the produt has variant defined.
            // NEW CALL HERE
            $variants = [];
            if ($variantIds && $variantIds->count() > 0) {
                $variants = ProductVariant::whereIn('id', $variantIds)->where('product_id', $productId)->get();
                \Log::debug('customers/me/orders store VariantsIds: ', [$variants]);
                if ($variants) {
                    \Log::debug('customers/me/orders store VariantsIds count : ', [$variants]);
                } else {
                    \Log::debug('customers/me/orders store VariantsIds count Zero');
                }
                // Check if has variants
                if ($variants->count() == 0) {
                    return response('Invalid product variant', 422);
                }

            } else {
                $variants = Product::where('id', $productId)->get();
                \Log::debug('customers/me/orders store NO VariantsIds: ', [$variants]);
            }

            // 2. Find the higher price on variants
            // $price = $variants->max('price');
            $product = $variants->first();
            $price = $product->price_sale ? $product->price_sale : $product->price;
            \Log::debug('customers/me/orders store 5');
            $items[] = [
                'price' => $price,
                'amount' => $item['amount'],
                'product_id' => $productId,
            ];
        }

        $items = $order->items()->createMany($items);

        foreach ($items as $key => $item) {
            $item->variants()->attach($request->input("items.{$key}.variants.*.id"));
        }

        return response([
            'id' => $order->id,
            'items' => $order->items
        ]);
    }

    /**
     * Add item to exists order.
     *
     * @param  int          $orderId
     * @param  ItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function add($orderId, ItemRequest $request)
    {
        // 1. Find the order
        $order = $this->customer->orders()->open()->findOrFail($orderId);

        // 2. Find variants
        // Validate if variants belongs to `product_id`
        $productId = $request->input('item.product_id');
        $variantIds = $request->input('item.variants.*.id');

        $variants = ProductVariant::whereIn('id', $variantIds)->where('product_id', $productId)->get();

        // Check if has variants
        if ($variants->count() == 0) {
           return response('Invalid product variant', 422);
        }

        // 2. Find the higher price on variants
        $price = $variants->max('price');

        // 3. Add item to the order
        $item = $order->items()->create([
            'price' => $price,
            'amount' => $request->input('item.amount'),
            'product_id' => $productId,
        ]);

        // Attach product variants to item
        $item->variants()->attach($request->input('item.variants.*.id'));

        return new ItemResource($item);
    }

    /**
     * Show order by id.
     *
     * @param  Order $order
     * @return void
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update order item amount.
     *
     * @param  int  $orderId
     * @param  int  $itemId
     * @param  ItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update($orderId, $itemId, ItemRequest $request)
    {
        $order = $this->customer->orders()->open()->findOrFail($orderId);
        $item = $order->items()->findOrFail($itemId);

        $item->update([
            'amount' => $request->input('item.amount')
        ]);

        return response('oka');
    }

    /**
     * Remove item from order.
     *
     * @param  int  $orderId
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function remove($orderId, $itemId)
    {
        $order = $this->customer->orders()->open()->findOrFail($orderId);

        $item = $order->items()->findOrFail($itemId);
        $item->variants()->detach();
        $item->delete();

        return response('oka');
    }
}
