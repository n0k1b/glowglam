<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingCurrency extends Model
{
    protected $fillable = [
        'default_currency_code',
        'default_currency',
        'currency_format',
        'exchange_rate_service',
        'fixer_access_key',
        'forge_api_key',
        'currency_data_feed_key',
        'auto_refresh',
    ];
}
