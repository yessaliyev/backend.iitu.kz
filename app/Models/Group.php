<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name_en',
        'name_ru',
        'name_kk',
        'specialty_id',
        'o_id'
    ];
}
