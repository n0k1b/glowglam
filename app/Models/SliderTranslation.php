<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderTranslation extends Model
{
    protected $fillable = [
        'slider_id',
        'locale',
        'slider_title',
        'slider_subtitle',
    ];
}
