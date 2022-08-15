<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingFacebook extends Model
{
    protected $fillable = [
        'status',
        'app_id',
        'app_secret',
    ];
}
