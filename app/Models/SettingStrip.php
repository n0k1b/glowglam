<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingStrip extends Model
{
    protected $fillable = [
        'status',
        'label',
        'description',
        'publishable_key',
        'secret_key',
    ];
}
