<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'width', 'height', 'resize_ratio',
    ];

    public function medias()
    {
        return $this->hasMany(Media::class);
    }
}
