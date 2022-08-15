<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['slug','is_active'];

    public function menuTranslations()
    {
    	return $this->hasMany(MenuTranslation::class,'menu_id');
    }

    public function MenuItem(){
		    return $this->hasMany('App\Models\MenuItem','id','menu_id');
    }
}
