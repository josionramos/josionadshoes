<?php

namespace App\Models\Order;

use App\Models\Product\Product;
use App\Models\Product\Variant;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'order_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price', 'amount', 'order_id', 'product_id'
    ];

    public function getTotalAttribute()
    {
        $product = $this->product;
        $price = $product->price_sale ? $product->price_sale : $product->price;

        return $this->amount * $price;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'order_item_variants', 'order_item_id', 'product_variant_id');
    }
}
