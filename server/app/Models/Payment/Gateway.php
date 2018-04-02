<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'payment_gateways';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
    ];
}
