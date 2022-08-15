<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{

    protected $fillable = [
        'brand_id', 'local','brand_name',
    ];

    public function brand() 
    {
        return $this->belongsTo('App\Models\Brand','brand_id','id');
    }
}
