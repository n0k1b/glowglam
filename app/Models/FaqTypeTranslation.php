<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqTypeTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_type_id','locale','type_name'
    ];
}
