<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['department_id','user_id','regalia_id'];

    public function schedule(){
        return $this->hasMany('\App\Models\Schedule','teacher_id','id');
    }

    public function subjects(){
        return $this->belongsToMany('App\Models\Subject','schedules');
    }
}
