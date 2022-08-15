<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    protected $fillable = [
        'tag_id',
        'local',
        'tag_name',
    ];
}
