<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingBankTransfer extends Model
{
    protected $fillable = [
        'status',
        'label',
        'description',
        'instruction',
    ];
}
