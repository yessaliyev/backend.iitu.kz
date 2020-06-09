<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Lesson extends Model
{
    protected $fillable = [
        'subject_id',
        'subject_type_id',
        'teacher_id',
        'group_id',
        'room_id',
        'date'
    ];

    public static function boot()
    {
        parent::boot();
        self::created(function($model){
            $students = Group::findOrFail($model->group_id)->attendanceStudents;
            if (empty($students)) {
                throw new BadRequestHttpException('4e ttam');
            }
            file_put_contents(public_path().'/testest.json',json_encode($students));
            foreach ($students as $student){
                Attendance::firstOrCreate([
                    'student_id' => $student->id,
                    'lesson_id' => $model->id,
                    'status' => Attendance::ABSENT
                ]);
            }
        });
    }

    public static function studentsAttendance($lesson_id)
    {
        return DB::table('lessons')
            ->leftJoin('attendances','lessons.id','=','attendances.lesson_id')
            ->leftJoin('students','attendances.student_id','=','students.id')
            ->leftJoin('users','students.user_id','=','users.id')
            ->select(
                'students.id as student_id',
                        'attendances.id as attendance_id',
                        'attendances.status',
                        'users.first_name',
                        'users.last_name',
                        'attendances.notes')
            ->where('lessons.id','=',$lesson_id)
            ->get();
    }

    public static function createLesson($request,$teacher_id)
    {
        $room = Room::firstOrCreate(['room_num' => $request->room_num]);
        $request->room_id = $room->id;

        self::firstOrCreate([
            'subject_id' => $request->subject_id,
            'subject_type_id' => $request->subject_type_id,
            'teacher_id' => $teacher_id,
            'group_id' => $request->group_id,
            'room_id' => $room->id,
            'date' => $request->date. ' ' .$request->time
        ]);

        if ($request->repeats != null and $request->repeats > 0 ){

            $filtered = Arr::where($request->days, function ($value, $key) {
                return $value == true;
            });

            for($i = 0; $i < $request->repeats; $i++){
                foreach ($filtered as $key => $value ){
                    $date = date('Y-m-d', strtotime('next '.$key , strtotime($request->date)));
                    self::firstOrCreate([
                        'subject_id' => $request->subject_id,
                        'subject_type_id' => $request->subject_type_id,
                        'teacher_id' => $teacher_id,
                        'group_id' => $request->group_id,
                        'room_id' => $room->id,
                        'date' => $date.' '.$request->time
                    ]);
                }
                $request->date = $date;
            }
        }

        return response(['msg' => "OK!"]);
    }

    public function group()
    {
        return $this->hasOne('\App\Models\Group','id');
    }
}
