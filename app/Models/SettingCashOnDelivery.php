<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCashOnDelivery extends Model
{
    protected $fillable = [
        'status',
        'label',
        'description'
    ];
}
