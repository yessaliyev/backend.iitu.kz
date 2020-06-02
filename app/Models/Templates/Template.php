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
        date_default_timezone_set('Asia/Almaty');
        $start = time();
        $end = time()+660;

        $sql = DB::select(
            'select t.* from templates t
                    left join students s on t.user_id = s.user_id
                    left join groups g on s.group_id = g.id
                    left join (
                        select * from lessons where room_id = '.$room_id.' and date > (SELECT TIMESTAMP \'epoch\' + '.$start.' * INTERVAL \'1 second\')
                                                                           and  date <  (SELECT TIMESTAMP \'epoch\' + '.$end.' * INTERVAL \'1 second\')
                        ) lesson on lesson.group_id = s.group_id where lesson.room_id = '.$room_id
        );


    }
}
