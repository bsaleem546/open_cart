<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'attribute_id',
        'name',
    ];

    public function _attributes()
    {
        return $this->belongsTo(Attributes::class, 'attribute_id');
    }
}
