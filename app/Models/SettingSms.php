<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingSms extends Model
{
    protected $fillable = [
        'sms_from',
        'sms_service',
        'api_key',
        'api_secret',
        'account_sid',
        'auth_token',
        'welcome_sms',
        'new_order_sms_to_admin',
        'new_order_sms_to_customer',
        'sms_order_status',
    ];
}
