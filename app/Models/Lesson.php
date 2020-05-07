<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function studentsAttendance($lesson_id)
    {
        return DB::table('students')
            ->leftJoin('attendances','attendances.student_id' , 'students.id')
            ->leftJoin('lessons','lessons.group_id', '=', 'students.group_id')
            ->leftJoin('users','students.user_id', '=', 'users.id')
            ->select(
                'students.id as student_id',
                        'attendances.id as attendance_id',
                        'attendances.status',
                        'users.first_name',
                        'users.last_name',
                        'attendances.notes')
            ->where('lesson_id','=',$lesson_id)

            ->get();
    }

    public function group()
    {
        return $this->hasOne('\App\Models\Group','id');
    }
}
