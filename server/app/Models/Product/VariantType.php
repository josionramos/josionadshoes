<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class VariantType extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'product_variant_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
