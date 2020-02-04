<?php

namespace App\Http\Controllers\Api;

use App\Attendance;
use App\Http\Controllers\Controller;
use App\SentTemplate;
use Illuminate\Http\Request;
use App\User;

class AttendanceController extends Controller
{
    public function setAttendance(Request $request)
    {
        $validate_data = $request->validate([
           'room_id'=>'required',
           'index'=>'required'
        ]);

        $sent_data = SentTemplate::where('room_id' , $request->room_id)->order_by('id','desc')->first();

        if (empty()) return response(['message' => 'room not found']);

        $attendance = new Attendance()

        return response([
           'message' => "OK!"
        ]);
    }

    public function getAttendance(Request $request)
    {
        $validate_data = $request->validate([
           'user_id'=>'required',
       ]);

        return response([
           'message' => "OK!"
        ]);
    }


}
