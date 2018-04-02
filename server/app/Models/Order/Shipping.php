<?php

namespace App\Models\Order;

use App\Models\Address\Address;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tracker', 'price', 'address_id', 'order_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
