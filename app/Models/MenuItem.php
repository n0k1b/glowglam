<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id',
        'type',
        'category_id',
        'page_id',
        'url',
        'icon',
        'target',
        'parent_id',
        'is_fluid',
        'is_active',
    ];

    public function menuItemTranslations(){
    	return $this->hasMany(MenuItemTranslation::class,'menu_item_id');
    }

    public function parentMenu(){
        return $this->belongsTo(self::class,'parent_id');
    }

    public function childs(){
        return $this->hasMany('App\Models\MenuItem','parent_id');
    }

    public function page(){
		return $this->hasOne('App\Models\Page','id','page_id');
    }
}
