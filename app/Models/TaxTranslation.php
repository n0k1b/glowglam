<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxTranslation extends Model
{
    protected $fillable = [
        'tax_id',
        'locale',
        'tax_class',
        'tax_name',
        'state',
        'city',
    ];
}
