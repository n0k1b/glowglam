<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class AttributeTranslation extends Model
{
    protected $fillable = [
        'attribute_id',
        'local',
        'attribute_name'
    ];

    //Shop Product Controller index()
    public function attributeValueTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasMany(AttributeValueTranslation::class,'attribute_id','attribute_id')
                    ->where('local',$locale);
    }
}
