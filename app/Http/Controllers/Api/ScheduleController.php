<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function create(Request $request){
       if (Schedule::validateRequest($request)){
            return Schedule::create($request);
       }

       return false;
    }

    public function get(Request $request){

    }

    public function getAll(Request $request){

    }

    public function update(Request $request){

    }

    public function delete(Request $request){

    }
}
