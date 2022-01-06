<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading', 'sub_heading', 'text', 'img', 'btn_text', 'btn_link', 'position'
    ];
}
