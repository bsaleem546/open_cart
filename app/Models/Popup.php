<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'sub_title', 'optional_sub_title', 'img', 'btn_text', 'btn_link', 'status'
    ];
}
