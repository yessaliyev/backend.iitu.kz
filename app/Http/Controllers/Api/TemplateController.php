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
           'template'=>'required'
        ]);

        $template = Template::updateOrCreate(['template' => $request->template,'user_id' => $request->user_id]);

        if (empty($template)) return response(['message' => "not found"]);

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
