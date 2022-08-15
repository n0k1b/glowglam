<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingNewsletter extends Model
{
    protected $fillable = [
        'newsletter',
        'mailchimp_api_key',
        'mailchimp_list_id',
    ];
}
