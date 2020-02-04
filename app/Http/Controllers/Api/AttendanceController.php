<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AttendanceController extends Controller
{
    public function setAttendance(Request $request)
    {
        $validate_data = $request->validate([
           'user_id'=>'required',
           'template_id'=>'required'
       ]);

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
