<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'payment_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'code', 'gateway_id',
    ];
}
