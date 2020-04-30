<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Week;
use Illuminate\Http\Request;
use Auth;

class SubjectController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name_kk' => 'required',
            'name_ru' => 'required',
            'name_en' => 'required',
        ]);

        $subject = Subject::firstOrCreate([
            'name_en' => $request->name_en,
            'name_ru' => $request->name_ru,
            'name_kk' => $request->name_kk,
        ]);

        return response(['error' => false,'msg' => "OK!"]);
    }

    public function update(Request $request)
    {
        $request->validate(['subject_id' => $request->subject_id]);
        $subject = Subject::findOrFail($request->subject_id);

        if (!empty($request->name_kk)) $subject->name_kk = $request->name_kk;
        if (!empty($request->name_ru)) $subject->name_ru = $request->name_ru;
        if (!empty($request->name_en)) $subject->name_en = $request->name_en;

        if (!$subject->save()) {
            return response(['error' => true,'msg' => 'something wrong with saving on line. '.__LINE__],500);
        }

        return response(['error' => false,'msg' => "OK!"]);
    }

    public function get()
    {

        if (Auth::user()->role->role === 'student')
            return Auth::user()->student->group->subjects;

        if (Auth::user()->role->role === 'teacher')
            return Auth::user()->teacher->subjects;


        return false;
    }

    public function delete(Request $request)
    {

    }

    public function addType(Request $request){

    }

    public function getStudentWeeks(){
        $res = [];

        foreach (Week::all() as $week){
            $res[] = [
                'id' => $week->id,
                'start' => date('d-M', strtotime($week->start)),
                'end' => date('d-M', strtotime($week->end)),
                'week_num' => $week->week_num
            ];
        }
        return $res;
    }

    public function getTeacherWeeks(){
        $res = [];

        foreach (Week::all() as $week){
            $res[] = [
                'id' => $week->id,
                'start' => date('d-M', strtotime($week->start)),
                'end' => date('d-M', strtotime($week->end)),
                'week_num' => $week->week_num
            ];
        }
        return $res;
    }


    public function getAttendance(Request $request){
        $request->validate(['group_id' => 'required','subject_id' => 'required']);
        return Subject::attendance($request->group_id,$request->subject_id);
    }

    public function createLesson(Request $request){
        $request->validate([
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'subject_type_id' => 'required',
            'group_id' => 'required',
            'date' => 'required',
            'room_id' => 'required',
        ]);

        return Lesson::firstOrCreate($request->all());
    }

}
