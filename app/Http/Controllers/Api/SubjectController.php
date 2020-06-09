<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\SubjectType;
use App\Models\Week;
use App\Models\WeekTask;
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

        return response(['error' => false, 'msg' => "OK!"]);
    }

    public function update(Request $request)
    {
        $request->validate(['subject_id' => $request->subject_id]);
        $subject = Subject::findOrFail($request->subject_id);

        if (!empty($request->name_kk)) $subject->name_kk = $request->name_kk;
        if (!empty($request->name_ru)) $subject->name_ru = $request->name_ru;
        if (!empty($request->name_en)) $subject->name_en = $request->name_en;

        if (!$subject->save()) {
            return response(['error' => true, 'msg' => 'something wrong with saving on line. ' . __LINE__], 500);
        }

        return response(['error' => false, 'msg' => "OK!"]);
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

    public function addType(Request $request)
    {

    }

    public function getStudentWeeks()
    {
        $res = [];

        foreach (Week::all() as $week) {
            $res[] = [
                'id' => $week->id,
                'start' => date('d-M', strtotime($week->start)),
                'end' => date('d-M', strtotime($week->end)),
                'week_num' => $week->week_num
            ];
        }
        return $res;
    }

    public function getWeeks()
    {
        $result = [];

        foreach (Week::all() as $week) {
            $res = [
                'id' => $week->id,
                'start' => date('d-M', strtotime($week->start)),
                'end' => date('d-M', strtotime($week->end)),
                'week_num' => $week->week_num,
                'task' => $week->getTasks,
            ];

            if (isset($week->getTasks->filenames)) {
                $res['task']->filenames = json_decode($week->getTasks->filenames);
            }
            $result[] = $res;
        }

        return $result;
    }

    public function addToWeek(Request $request)
    {
        $request->validate([
            'week_id' => 'required|integer',
            'title' => 'required'
        ]);

        $data = $request->all();
        if ($request->file('files')) {
            $filenames = WeekTask::uploadTaskFile($request->file('files'));
//            return gettype($filenames);
            $data['filenames'] = $filenames;
            unset($data['files']);
        }
        $week_task = WeekTask::where('week_id',$request->week_id)
            ->where('title',$request->title)
            ->where('content',$request->content)
            ->first();

        if (empty($week_task)) $week_task = new WeekTask();
        $week_task->week_id = $request->week_id;
        $week_task->subject_id = $request->subject_id;
        $week_task->title = $request->title;
        $week_task->content = isset($request->content) ? $request->content : null;
        $week_task->filenames = isset($data['filenames']) ? $data['filenames'] : null;
        $week_task->save();

        return response(['res' => $week_task]);
    }

    public function getAttendance(Request $request)
    {
        $request->validate(['group_id' => 'required', 'subject_id' => 'required']);
        return Subject::attendance($request->group_id, $request->subject_id);
    }

    public function createLesson(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'subject_type_id' => 'required',
            'group_id' => 'required',
            'date' => 'required',
            'room_num' => 'required',
        ]);

        return Lesson::createLesson($request, Auth::user()->teacher->id);
    }

    public function getTypes()
    {
        return SubjectType::all();
    }

    public function getGroups(Request $request)
    {
        $request->validate(['subject_id' => 'required|integer']);
        return Subject::findOrFail($request->subject_id)->groups;
    }

    public function getSubjectById(Request $request)
    {
        return Subject::findOrFail($request->id);
    }

}
