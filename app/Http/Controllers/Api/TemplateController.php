<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Templates\SentTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Templates\Template;

class TemplateController extends Controller
{
    public function set(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'template' => 'required',
            'finger_id' => 'required'
        ]);

        return Template::firstOrCreate([
            'user_id' => $request->user_id,
            'template' => $request->template,
            'finger_id' => $request->finger_id
        ]);
    }

    public function get(Request $request)
    {
        $request->validate(['room_id' => 'required|integer']);
        if (!isset($request->test)) $request->test = false;

        $templates = Template::getByRoom($request->room_id, $request->test);

        $sent = SentTemplate::where('data', json_encode($templates, JSON_UNESCAPED_UNICODE))->first();

        if (!empty($sent) and !empty(json_decode($sent->data))) {
            return response([
                'new' => false,
                'templates' => json_decode($sent->data)

            ]);
        }

        $sent = new SentTemplate();
        $sent->room_id = $request->room_id;
        $sent->data = json_encode($templates, JSON_UNESCAPED_UNICODE);
        $sent->save();

        return response([
            'new' => true,
            'templates' => $templates
        ]);
    }
}
