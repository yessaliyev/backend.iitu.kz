<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;

class NewsController extends Controller
{
    public function add(Request $request){
        $request->validate(['title' => 'required','content' => 'required']);

        $news = News::firstOrCreate(['title' => $request->title,'content' => $request->content]);

        $news->touch();

        return response(['error' => false,'message' => 'ok']);
    }

    public function get(){
        return News::where('status',1)->get();
    }
}
