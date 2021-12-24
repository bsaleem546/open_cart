<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'sub_total',
        'discount',
        'discount_code',
        'shipping',
        'quantity',
        'total',
        'note',
        'attr',
        'status',
    ];
}
