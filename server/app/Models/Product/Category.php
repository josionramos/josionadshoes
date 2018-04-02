<?php

namespace App\Models\Product;

use App\Models\Product\VariantType;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'parent_id', 'active',
    ];

    /**
     * Scope a query to only include active products.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function variants()
    {
        return $this->belongsToMany(VariantType::class, 'product_category_variants');
    }
}
