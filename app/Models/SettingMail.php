<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingMail extends Model
{
    protected $fillable = [
        'mail_address',
        'mail_name',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'welcome_email',
        'new_order_to_admin',
        'invoice_mail',
        'mail_order_status',
    ];
}
