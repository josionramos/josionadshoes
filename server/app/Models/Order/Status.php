<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * Order started.
     *
     * @var integer
     */
    const STARTED = 1;

    /**
     * Order wait for payment.
     *
     * @var integer
     */
    const WAIT_PAYMENT = 2;

    /**
     * Order in the packaging process.
     *
     * @var integer
     */
    const PACKAGING = 3;

    /**
     * Order shipped for transportation.
     *
     * @var integer
     */
    const SHIPPED = 4;

    /**
     * Order finished.
     *
     * @var integer
     */
    const FINISHED = 4;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'order_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
    ];
}
