<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Template;

class TemplateController extends Controller
{
    public function setTemplate(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'template'=>'required',
            'finger_id' => 'required'
        ]);

        $template = Template::updateOrCreate(['finger_id' => $request->finger_id,'user_id' => $request->user_id]);

        return $template;
    }

    public function getTemplate(Request $request)
    {
        $request->validate([
           'user_id'=>'required',
        ]);

        $template = Template::where(['user_id',$request->user_id])->get();

        if (empty($template)) return response(['message' => 'not found']);

        return $template;
    }
}
