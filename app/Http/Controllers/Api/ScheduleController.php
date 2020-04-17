<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function create(Request $request){
       if (Schedule::validateRequest($request)){
            return Schedule::create($request);
       }

       return false;
    }

    public function get(Request $request)
    {
        $request->validate(['group_id' => 'required']);
        return DB::table('schedules')
            ->leftJoin('teachers', 'schedules.o_teacher_id', '=', 'teachers.id')
            ->leftJoin('subjects', 'schedules.o_subject_id', '=', 'subjects.id')
            ->leftJoin('subject_types', 'schedules.o_subject_type_id', '=', 'subject_types.id')
            ->leftJoin('groups', 'schedules.o_group_id', '=', 'groups.id')
            ->leftJoin('rooms', 'schedules.o_room_id', '=', 'rooms.id')
            ->leftJoin('appointments', 'schedules.o_appointment_id', '=', 'appointments.id')
            ->leftJoin('times', 'schedules.o_time_id', '=', 'times.id')
            ->leftJoin('days', 'schedules.o_day_id', '=', 'days.id')
            ->where('schedules.o_group_id','=',$request->group_id)

            ->get();
    }

    public function getAll(Request $request){

    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }
}
