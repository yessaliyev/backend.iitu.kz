<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Specialty;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'name_kk' => 'required',
            'name_ru' => 'required',
            'name_en' => 'required',
            'specialty_id' => 'required',
            'course' => 'required'
        ]);

        $spec = Specialty::findOrFail($request->specialty_id);

        $group = Group::firstOrCreate([
            'name_en' => $request->name_en,
            'name_ru' => $request->name_ru,
            'name_kk' => $request->name_kk,
            'specialty_id' => $spec->id,
            'course' => $request->course
        ]);

        return response(['error' => false,'msg' => "OK!"]);
    }

    public function update(Request $request)
    {
        $request->validate(['group_id' => $request->specialty_id]);
        $group = Group::where('id',$request->group_id)->firstOrFail();

        if (!empty($request->name_kk)) $group->name_kk = $request->name_kk;
        if (!empty($request->name_ru)) $group->name_ru = $request->name_ru;
        if (!empty($request->name_en)) $group->name_en = $request->name_en;

        if (!$group->save()) {
            return response(['error' => true,'msg' => 'something wrong with saving on line. '.__LINE__],500);
        }

        return response(['error' => false,'msg' => "OK!"]);
    }

    public function get(Request $request)
    {

    }

    public function getAll(Request $request)
    {
       $request->validate(['course' => 'required|integer']);
       return Group::where('course',$request->course)->get();
    }

    public function delete(Request $request)
    {

    }
}
