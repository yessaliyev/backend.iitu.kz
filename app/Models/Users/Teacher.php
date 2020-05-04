<?php

namespace App\Models\Users;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['department_id','user_id','regalia_id'];

    public function schedule(){
        return $this->hasMany('\App\Models\Schedule','teacher_id','id');
    }

    public function subject(){
        return $this->belongsToMany('App\Models\Subject','schedules');
    }

    public function subjects(){
        return $this->belongsToMany('App\Models\Subject','teachers_subjects');
    }

    public function groups(){
        return $this->hasManyThrough('App\Models\Group','teachers_subjects');
    }

    public static function subjectGroups($subject_id){
        return Subject::findOrFail($subject_id)->subjectGroups;
    }
}
