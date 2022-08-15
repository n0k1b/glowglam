<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCheckMoneyOrder extends Model
{
    protected $fillable = [
        'status',
        'label',
        'description',
        'instruction',
    ];
}
