<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img',
        'slug',
    ];

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'type_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
