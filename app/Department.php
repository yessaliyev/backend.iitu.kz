<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name_en',
        'name_ru',
        'name_kk',
        'o_id'
    ];
}
