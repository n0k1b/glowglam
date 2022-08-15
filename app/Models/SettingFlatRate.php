<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingFlatRate extends Model
{
    protected $fillable = [
        'flat_status',
        'label',
        'cost',
    ];
}
