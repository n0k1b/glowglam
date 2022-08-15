<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingStore extends Model
{
    protected $fillable = [
        'store_name',
        'store_tagline',
        'store_email',
        'store_phone',
        'store_address_1',
        'store_address_2',
        'store_city',
        'store_country',
        'store_state',
        'store_zip',
        'hide_store_phone',
        'hide_store_email',
        'admin_logo',
    ];
}
