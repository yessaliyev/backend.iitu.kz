<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Templates\SentTemplate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AttendanceController extends Controller
{
    public function set(Request $request)
    {
        $request->validate([
            'room_id' => 'required',
            'index' => 'required',
        ]);

        if (!isset($request->status)) $request->status = 1;

        $sent_data = SentTemplate::where('room_id', $request->room_id)->orderBy('id', 'desc')->first();
        if (empty($sent_data)) return response(['message' => 'not found']);
        $student = User::findOrFail(json_decode($sent_data->data, true)[$request->index]['user_id'])->student;
        $lesson = $student->group->currentLesson();

        throw_if(empty($lesson), new NotFoundHttpException('current lesson not found'));

        Attendance::updateOrCreate([
            'lesson_id' => $lesson->id,
            'student_id' => $student->id], ['status' => $request->status]);

        return response([
            'message' => "OK!"
        ]);
    }

    public function getCourseAttendance()
    {
        return Attendance::teacherLessons(Auth::user()->teacher->id, 10);
    }

    public function getGroupAttendance(Request $request)
    {
        $request->validate(['lesson_id' => 'required|integer']);
        return Lesson::studentsAttendance($request->lesson_id);
    }

    public function setStudentsAttendance(Request $request)
    {
        $request->validate([
            'students' => 'required',
            'lesson_id' => 'required'
        ]);

        return Attendance::setStudentAttendance($request);
    }


}
