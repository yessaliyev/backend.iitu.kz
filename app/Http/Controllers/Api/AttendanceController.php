<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use App\Http\Controllers\Controller;
use App\Models\Templates\SentTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function set(Request $request)
    {
        $validate_data = $request->validate([
           'room_id'=>'required',
           'index'=>'required'
        ]);

        $sent_data = SentTemplate::where('room_id' , $request->room_id)->orderBy('id','desc')->first();

        if (empty($sent_data)) return response(['message' => 'room not found']);

        $att = new Attendance();
        $att->room_id = $request->room_id;
        $att->user_id = json_decode($sent_data->data,true)[$request->index]['user_id'];
        $att->status = 1;
        $att->save();

        return response([
           'message' => "OK!"
        ]);
    }

    public function getCourseAttendance()
    {
        return Attendance::teacherLessons(Auth::user()->teacher->id,10);
    }




}
