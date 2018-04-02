<?php

namespace App\Models\Instagram;

use Illuminate\Database\Eloquent\Model;

class Instagram extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nickname', 'avatar', 'token', 'account_id',
    ];
}
