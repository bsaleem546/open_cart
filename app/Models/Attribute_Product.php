<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute_Product extends Model
{
    use HasFactory;

    protected $table = 'attribute_product';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'option_id',
        'quantity',
        'price',
        'in_stock'
    ];

    public function _options()
    {
        return $this->hasMany(Options::class, 'attribute_id');
    }
}
