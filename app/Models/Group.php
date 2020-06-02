<?php

namespace App\Models;

use App\Models\Users\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function students($group_id){
        $select = [
            'students.id as student_id','users.id as user_id','users.first_name',
            'users.middle_name','users.last_name','groups.id as group_id',
            'groups.name_en'
        ];
        return DB::table('users')
            ->leftJoin('students','students.user_id','=','users.id')
            ->leftJoin('groups','students.group_id', '=','groups.id')
            ->where('groups.id',$group_id)
            ->select($select)
            ->get();
    }

    public function currentLesson(){
        return Lesson::where('date','>', Carbon::now()->toDateString())
            ->where('date','<',Carbon::now()->addMinutes(11))
            ->where('group_id',$this->id)->first();
    }


}
