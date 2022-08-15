<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingLocalPickup extends Model
{
    protected $fillable = [
        'pickup_status',
        'label',
        'cost',
    ];
}
