<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryTranslation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'local','category_name',
    ];
    protected $dates = ['deleted_at'];


    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id','id');
    }
}
