<?php

namespace App\Models\Templates;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Template extends Model
{
    protected $fillable = ['user_id','template','finger_id'];

    public static function getByRoom($room_id)
    {
        return DB::table('templates')
                ->leftJoin('groups','groups.id','=','students.group_id')
                ->leftJoin('schedules','schedules.group_id','=','students.group_id')
                ->leftJoin('rooms','rooms.id','=','schedules.room_id')
            ->get();
    }
}
