<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function add(Request $request){
        $request->validate(['title' => 'required','text' => 'required']);

        $news = News::firstOrCreate(['title' => $request->title,'content' => $request->text]);

        $news->touch();

        return response(['error' => false,'message' => 'ok']);
    }

    public function get(){
        return News::where('status',1)->get();
    }

    public function getById(Request $request){
        $request->validate(['news_id' => 'required|integer']);
        return News::findOrFail($request->news_id);
    }
}
