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
}
