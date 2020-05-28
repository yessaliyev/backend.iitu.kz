<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekTask extends Model
{
    protected $fillable = [
        'week_id',
        'subject_id',
        'title',
        'content',
        'filenames',
        'status',
    ];

    protected $casts = ['filenames' => 'array'];


    public static function uploadTaskFile($files)
    {
        $names = [];
        foreach ($files as $file) {
            if (!$file->isValid()) return false;
            $file_name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);
            $names[] = $file_name;
        }

        return json_encode($names,JSON_UNESCAPED_UNICODE);
    }

}
