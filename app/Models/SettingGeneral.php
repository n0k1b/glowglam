<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingGeneral extends Model
{
    protected $fillable = [
        'supported_countries',
        'default_country',
        'default_timezone',
        'customer_role',
        'number_format',
        'reviews_and_ratings',
        'auto_approve_reviews',
        'cookie_bar',
    ];
}
