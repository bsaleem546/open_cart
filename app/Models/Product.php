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
        'in_stock',
        'has_attributes',
    ];

    public function _attributes(){
        return $this->belongsToMany(Attributes::class, 'attribute_product');
    }
}