<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingGoogle extends Model
{
    protected $fillable = [
        'status',
        'client_id',
        'client_secret',
    ];
}
