<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingAboutUsTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_about_us_id',
        'locale',
        'title',
        'description',
    ];

}
