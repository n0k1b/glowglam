<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingPaypal extends Model
{
    protected $fillable = [
        'status',
        'label',
        'description',
        'sandbox',
        'client_id',
        'secret',
    ];
}
