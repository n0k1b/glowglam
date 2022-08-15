<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorefrontMenu extends Model
{
    public function menu(){
		return $this->hasOne('App\Models\Menu','id','primary_menu_id');
    }
}
