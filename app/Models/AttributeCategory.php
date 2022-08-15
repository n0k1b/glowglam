<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class AttributeCategory extends Model
{
    use HasFactory;

    protected $table = 'attribute_category';

    public function attributeValueTranslation()
    {
        $locale = Session::get('currentLocal');
        return $this->hasMany(AttributeValueTranslation::class,'attribute_id','attribute_id')
                    ->where('local',$locale);;
    }

}
