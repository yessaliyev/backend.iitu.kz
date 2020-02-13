<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getUser(Request $request){
       return User::with('roles')->find($request->user()->id);
    }
}
