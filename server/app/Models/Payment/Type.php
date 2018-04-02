<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'payment_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'code', 'gateway_id'
    ];
}
