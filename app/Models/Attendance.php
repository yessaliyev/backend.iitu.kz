<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attendance extends Model
{

    const ABSENT = 0;
    const PRESENT = 1;
    const REASON = 2;

    protected $fillable = ['lesson_id','student_id','status'];

    public static function teacherLessons($teacher_id,$limit = 10)
    {
        return DB::table('lessons')
        ->leftJoin('subjects', 'lessons.subject_id', '=', 'subjects.id')
        ->leftJoin('subject_types','subject_types.id','=','lessons.subject_type_id')
        ->leftJoin('teachers','teachers.id','=','lessons.teacher_id')
        ->leftJoin('groups','groups.id','=','lessons.group_id')
        ->leftJoin('rooms','rooms.id','=','lessons.room_id')
        ->select('lessons.*','groups.name_en','subject_types.type_en','rooms.room_num')
        ->where('lessons.teacher_id','=',$teacher_id)
        ->orderBy('date','asc')
        ->take($limit)
        ->get();
    }

    public static function setStudentAttendance($request)
    {
        foreach ($request->students as $student) {
            $attendance = self::updateOrCreate([
                'lesson_id' => $request->lesson_id,
                'student_id' => $student['student_id']], ['status' => $student['status']]);
        }

        return response(['error' => false,'message' => 'ok']);
    }
}
