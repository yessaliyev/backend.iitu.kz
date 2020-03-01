<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'o_id',
        'o_subject_id',
        'o_subject_type_id',
        'o_group_id',
        'o_teacher_id',
        'o_regalia_id',
        'o_appointment_id',
        'o_room_id',
        'o_day_id',
        'o_time_id'
    ];
}
