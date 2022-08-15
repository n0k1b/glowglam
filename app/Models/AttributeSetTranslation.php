<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeSetTranslation extends Model
{
    use SoftDeletes;

    protected $fillable = ['attribute_set_id','locale','attribute_set_name'];
    protected $dates = ['deleted_at'];
}
