<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'type_id',
        'over_all',
        'code',
        'value',
        'value_type',
        'begin_date',
        'end_date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'type_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'type_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'type_id');
    }

}
