<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    protected $fillable = [ 'name' ];

    public function _options()
    {
        return $this->hasMany(Options::class, 'attribute_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'attribute_product');
    }
}
