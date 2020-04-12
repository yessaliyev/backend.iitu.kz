<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Room;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'room_num'=>'required',
            'name_kk' => 'required',
            'name_ru' => 'required',
            'name_en' => 'required',
        ]);

        $room = Room::firstOrCreate(['room_num' => $request->room_num]);

        $department = Department::firstOrCreate([
            'room_id'=>$room->id,
            'name_en'=>$request->name_en,
            'name_ru'=>$request->name_ru,
            'name_kk'=>$request->name_kk,
        ]);

        return response('good');
    }

    public function get(Request $request)
    {
        $request->validate(['department_id' => 'required']);
        return Department::find($request->department_id);
    }

    public function getAll(Request $request)
    {
        return Department::all();
    }

    public function update(Request $request)
    {
        $request->validate(['department_id' => 'required']);

        $department = Department::find($request->department_id);

        if (empty($department)) return response('department_not_found',404);

        if (!empty($request->name_kk)) $department->name_kk = $request->name_kk;
        if (!empty($request->name_ru)) $department->name_ru = $request->name_ru;
        if (!empty($request->name_en)) $department->name_en = $request->name_en;
        if (!empty($request->room_num))
        {
            $room = Room::firstOrCreate(['room_num' => $request->room_num]);
            $department->room_id = $room->id;
        }

        if (!$department->save()) return response('something wrong with saving on line '.__LINE__,500);
    }

    public function delete(Request $request)
    {
        $request->validate(['department_id' => 'required']);
        return Department::destroy($request->department_id);
    }
}
