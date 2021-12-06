<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationValues extends Model
{
    use HasFactory;
    protected $table = 'variation_values';

    protected $fillable = ['product_id', 'combo_id', 'quantity', 'price', 'in_stock'];
}
