<?php

namespace App\Models\Product;

use App\Models\Media;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'title',
        'slug',
        'active',
        'featured',
        'price',
        'price_sale',
        'media_id',
        'category_id',
        'content',
        'description',
        'weight',
        'width',
        'height',
        'length',
        'stock',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function gallery()
    {
        return $this->hasOne(Gallery::class);
    }

    public function cover()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function images()
    {
        return $this->belongsToMany(Media::class, 'product_images');
    }

    /**
     * Scope a query to only include enable products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     *  Scope a query to retrive only active products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     *  Scope a query to retrive only enable products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query)
    {
        return $query->active()->has('variants');
    }
}
