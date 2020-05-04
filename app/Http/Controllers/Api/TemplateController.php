<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Templates\SentTemplate;
use Illuminate\Http\Request;
use App\Models\Templates\Template;

class TemplateController extends Controller
{
    public function set(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'template'=>'required',
            'finger_id' => 'required'
        ]);

        return Template::firstOrCreate($request->all());
    }

    public function get(Request $request)
    {
        $request->validate(['room_id' => 'required']);

        $templates = Template::all();

        if (empty($templates)) return response(['message' => 'not found']);

        $sent_template = SentTemplate::where('room_id', $request->room_id )->first();
        if (empty($sent_template)) $sent_template = new SentTemplate();
        $sent_template->data = json_encode($templates,JSON_UNESCAPED_UNICODE);
        $sent_template->room_id = $request->room_id;
        $sent_template->save();
        $sent_template->touch();

        return response([
            'templates' => $templates
        ]);
    }
}
