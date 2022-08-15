<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBillingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip_code',
        'is_default',
    ];
}
