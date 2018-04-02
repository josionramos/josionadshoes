<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'payment_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id', 'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
