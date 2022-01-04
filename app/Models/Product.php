<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'short_description',
        'long_description',
        'quantity',
        'price',
        'sale_price',
        'in_stock',
        'is_featured',
        'has_attributes',
    ];

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'type_id');
    }

    public function shippings()
    {
        return $this->belongsToMany(Shipping::class, 'shipping_product');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function singleImages()
    {
        return $this->hasMany(Image_Product::class, 'product_id', 'id')->limit(1);
    }

    public function images()
    {
        return $this->hasMany(Image_Product::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class, 'product_id');
    }

    public function variation_values()
    {
        return $this->hasMany(VariationValues::class, 'product_id', 'id');
    }

    public function _attributes()
    {
        return $this->hasMany(Attributes::class, 'product_id');
    }

    public function proer_product()
    {
        return $this->hasOne(OrderProduct::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

}
