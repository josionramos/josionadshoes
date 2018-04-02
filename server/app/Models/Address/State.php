<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'address_states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'uf',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uf';
    }

    /**
     * Get all cities from state.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
