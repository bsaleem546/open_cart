<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $fillable = [ 'city', 'rate' ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'shipping_product');
    }
}
