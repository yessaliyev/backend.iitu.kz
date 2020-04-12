<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name_kk' => 'required',
            'name_ru' => 'required',
            'name_en' => 'required',
        ]);

        $spec = Specialty::firstOrCreate([
            'name_en' => $request->name_en,
            'name_ru' => $request->name_ru,
            'name_kk' => $request->name_kk,
        ]);

        return response(['error' => false,'msg' => 'OK!']);
    }

    public function update(Request $request)
    {
        $request->validate(['specialty_id' => $request->specialty_id]);
        $spec = Specialty::where('id',$request->specialty_id)->firstOrFail();

        if (!empty($request->name_kk)) $department->name_kk = $request->name_kk;
        if (!empty($request->name_ru)) $department->name_ru = $request->name_ru;
        if (!empty($request->name_en)) $department->name_en = $request->name_en;
        if (!empty($request->code)) $department->code = $request->code;

        if (!$spec->save()) return response(['error' => true,'msg' => 'something wrong with saving on line. '.__LINE__],500);

        return response(['error' => false,'msg' => "OK!"]);
    }

    public function get(Request $request)
    {

    }

    public function delete(Request $request)
    {

    }
}
