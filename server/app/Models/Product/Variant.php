<?php

namespace App\Models\Product;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    use SoftDeletes;

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'product_variants';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'price', 'extra', 'active', 'media_id', 'type_id', 'product_id'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function type()
    {
        return $this->belongsTo(VariantType::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
