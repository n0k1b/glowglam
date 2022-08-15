<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorefrontImage extends Model
{
    protected $fillable = ['title','type','image','setting_id','created_at','updated_at'];
}
