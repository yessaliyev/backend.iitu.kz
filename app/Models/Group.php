<?php

namespace App\Models;

use App\Models\Users\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name_en',
        'name_ru',
        'name_kk',
        'specialty_id',
        'o_id',
        'course'
    ];

    public function subject(){
        return $this->belongsToMany('App\Models\Subject','schedules');
    }

    public function subjects(){
        return $this->belongsToMany('App\Models\Subject','groups_subjects');
    }

    public function studentsAttendance($date){

        $students = Student::where('group_id',$this->id)->get();

        $result = [];

        foreach ($students as $student){
            $result[] = $student->attendance();
        }
    }

    public function currentLesson(){
        return Lesson::where('date','>', Carbon::now()->toDateString())
            ->where('date','<',Carbon::now()->addMinutes(11))
            ->where('group_id',$this->id)->first();
    }


}
