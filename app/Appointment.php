<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'o_id',
        'appointment_en',
        'appointment_ru',
        'appointment_kk'
    ];
}
