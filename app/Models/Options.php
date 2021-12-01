<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;
    protected $fillable = [
        'attribute_id',
        'name',
//        'quantity',
//        'price',
//        'in_stock'
    ];

    public function _attribute()
    {
        return $this->belongsTo(Attributes::class, 'attribute_id');
    }

    public function product_attribute()
    {
        return $this->belongsTo(Attributes::class, 'attribute_id');
    }
}
