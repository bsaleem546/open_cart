<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    protected $fillable = [ 'product_id', 'name' ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function _options()
    {
        return $this->hasMany(Options::class, 'attribute_id');
    }
}
