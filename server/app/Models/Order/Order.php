<?php

namespace App\Models\Order;

use App\Customer;
use App\Events\Order\Creating;
use App\Models\Payment\Payment;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference', 'status_id', 'customer_id'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => Creating::class,
    ];

    /**
     * Get the sub total.
     *
     * @return float
     */
    public function getSubTotalAttribute()
    {
        $subTotal = $this->items->sum(function ($item) {
            return $item->amount * $item->price;
        });

        return $subTotal;
    }

    /**
     * Get the total.
     *
     * @return float
     */
    public function getTotalAttribute()
    {
        $shipping = $this->shipping ? $this->shipping->price : 0;

        return $shipping + $this->subTotal;
    }

    /**
     * Get all items from order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get order payment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get order status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Get order shipping.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    /**
     * Get order customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Filter query to remove pre-orders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen($query)
    {
        return $query->doesntHave('payment')->where('status_id', Status::STARTED);
    }

    public function scopeHasPayment($query)
    {
        return $query->has('payment');
    }
}
