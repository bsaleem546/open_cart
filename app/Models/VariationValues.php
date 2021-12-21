<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationValues extends Model
{
    use HasFactory;
    protected $table = 'variation_values';

    protected $fillable = ['product_id', 'combo_id', 'quantity', 'price', 'sale_price', 'in_stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function varitions()
    {
        return $this->belongsTo(VariationValues::class, 'combo_id');
    }
}
