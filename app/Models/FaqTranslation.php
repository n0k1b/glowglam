<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class FaqTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_id',
        'locale',
        'title',
        'description',
    ];

    // protected $dates = ['deleted_at'];

}
