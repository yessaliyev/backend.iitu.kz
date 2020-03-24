<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectType extends Model
{
    protected $fillable = [
        'o_id',
        'type_en',
        'type_ru',
        'type_kk',
    ];
}
