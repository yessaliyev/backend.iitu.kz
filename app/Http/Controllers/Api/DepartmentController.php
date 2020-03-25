<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function createDepartment(Request $request)
    {
        $validate_data = $request->validate([
            'room_num'=>'required',
            'name' => 'required',
        ]);

        $room = Room::firstOrCreate()
    }
}
