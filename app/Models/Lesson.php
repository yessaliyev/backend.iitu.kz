<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //
    protected $fillable = [
        'subject_id',
        'subject_type_id',
        'teacher_id',
        'group_id',
        'room_id',
        'date'
    ];
}
