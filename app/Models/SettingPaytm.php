<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingPaytm extends Model
{
    protected $fillable = [
        'status',
        'label',
        'description',
        'sandbox',
        'merchant_id',
        'merchant_key',
    ];
}
