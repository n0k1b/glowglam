<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCustomCssJss extends Model
{
    protected $fillable = [
        'header',
        'footer',
    ];
}
