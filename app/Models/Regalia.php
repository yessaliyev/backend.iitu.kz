<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regalia extends Model
{
    protected $fillable = [
        'regalia_en',
        'regalia_ru',
        'regalia_kk',
        'o_id',
    ];
}
