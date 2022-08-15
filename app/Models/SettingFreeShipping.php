<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingFreeShipping extends Model
{
    protected $fillable = [
        'shipping_status',
        'label',
        'minimum_amount',
    ];
}
