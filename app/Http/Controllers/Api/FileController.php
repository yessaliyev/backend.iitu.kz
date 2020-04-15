<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\TaskUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Auth;


class FileController extends Controller
{
    public function upload(Request $request){

        $request->validate([
            'file' => 'required|mimes:pdf,xlx,xlsx,csv',
        ]);

        $file = $request->file('file');
        if (!$file->isValid()) return false;

        $file_name = time().'_'.$file->getClientOriginalName();

        $request->file->move(public_path('uploads'), $file_name);

        $task = new TaskUpload();
        $task->filename = $file_name;
        $task->status = 0;
        $task->user_id = Auth::user()->id;
        $task->save();

        chdir(base_path());
        $v = exec("php artisan command:upload ". $task->id ." > /dev/null &", $output, $return);
        return response(['task_id' => $task->id]);
    }
}
