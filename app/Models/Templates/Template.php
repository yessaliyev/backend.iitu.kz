<?php

namespace App\Models\Templates;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Template extends Model
{
    protected $fillable = ['user_id','template','finger_id'];

    public static function getByRoom($room_id)
    {
        $start_time = Carbon::now()->toDateString();
        $end_time = Carbon::now()->addMinutes(11)->toDateString();

        return DB::select(
            'select t.* from templates t
                    left join students s on t.user_id = s.user_id
                    left join groups g on s.group_id = g.id
                    left join (
                        select * from lessons where room_id = '.$room_id.' and date > '.$start_time.'
                                                                           and  date <  '.$end_time.'
                        ) lesson on lesson.group_id = s.group_id where lesson.room_id = '.$room_id
        );
    }
}
