<?php

namespace App\Models\Templates;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Template extends Model
{
    protected $fillable = ['user_id', 'template', 'finger_id'];

    public static function getByRoom($room_id, $test = false)
    {
        date_default_timezone_set('Asia/Almaty');
        $start = date('Y-m-d H:i:s', strtotime('+8 minutes'));
        $end = date('Y-m-d H:i:s', strtotime('+21 minutes'));
//        return [$start,$end];
        if ($test) {
            $start = date('Y-m-d H:i:s', strtotime('-2 weeks'));
            $end = date('Y-m-d H:i:s', strtotime('+2 weeks'));
        }

        return DB::select(
            "select *
                    from templates
                    where user_id in (select user_id
                      from students
                               left join users u on students.user_id = u.id
                               left join groups g on students.group_id = g.id
                               left join lessons l on g.id = l.group_id
                      where room_id = " . $room_id . " and l.date between '" . $start . "'
                      and '" . $end . "'
            )"
        );


    }
}
