<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image_Product extends Model
{
    use HasFactory;

    protected $table = 'image_product';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'paths',
        'is_main',
    ];
}
