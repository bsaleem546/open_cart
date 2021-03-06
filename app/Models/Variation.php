<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;
    protected $table = 'variations';

    protected $fillable = ['product_id', 'option_name', 'combo_id'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function varition_values()
    {
        return $this->hasMany(VariationValues::class, 'combo_id');
    }
}
