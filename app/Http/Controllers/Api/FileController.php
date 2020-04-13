<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request){
        $request->validate([
            'file' => 'required|mimes:pdf,xlx,xlsx,csv',
        ]);
        $file = $request->file('file');
        $file_name = time().'_'.$file->getClientOriginalName();
        $request->file->move(public_path('uploads'), $file_name);

    }
}
