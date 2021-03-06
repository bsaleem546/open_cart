<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'fname', 'lname', 'address', 'city', 'country', 'phone', 'notes'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
