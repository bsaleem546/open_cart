<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'img', 'text1', 'text2', 'text3', 'text4', 'btn_text', 'btn_link'
    ];
}
