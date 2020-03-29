<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
       return User::with('roles')->find($request->user()->id);
    }

    public function createTeacher(Request $request)
    {
        $validate_data = $request->validate([
            'username'=>'required|unique:users',
            'password'=>'required|confirmed',
            'role' => 'required|string'
        ]);

    }

    public function addAppointment(Request $request){
        $request->validate([
            'appointment_en' => 'required',
            'appointment_ru' => 'required',
            'appointment_kk' => 'required'
        ]);

        return Appointment::

    }
}
