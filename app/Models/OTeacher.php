<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTeacher extends Model
{
    protected $fillable = [
        'o_id',
        'teacher_en',
        'teacher_ru',
        'teacher_kk'
    ];
}
