<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading', 'img', 'btn_text', 'btn_link'
    ];
}
