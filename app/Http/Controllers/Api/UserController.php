<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Role;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function get(Request $request)
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

    public function createAppointment(Request $request){
        $request->validate([
            'appointment_en' => 'required',
            'appointment_ru' => 'required',
            'appointment_kk' => 'required'
        ]);

        return Appointment::firstOrCreate([
            "appointment_en" => $request->appointment_en,
            "appointment_ru" => $request->appointment_ru,
            "appointment_kk" => $request->appointment_kk,
        ]);
    }

    public function getRoles(){
        return Role::all();
    }
}
