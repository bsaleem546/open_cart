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
        'short_description',
        'long_description',
        'quantity',
        'price',
        'sale_price',
        'in_stock',
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
        return $this->hasOne(Category::class);
    }
}
