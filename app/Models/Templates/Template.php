<?php

namespace App\Models\Templates;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Template extends Model
{
    protected $fillable = ['user_id', 'template', 'finger_id'];

    public static function getByRoom($room_id,$test = false)
    {
        date_default_timezone_set('Asia/Almaty');
        $start = time();
        $end = time() + 660;

        if ($test){
            $start = 0;
            $end = time()+157220;
        }

        return DB::select(
            'select *
                    from templates
                    where user_id in (select user_id
                      from students
                               left join users u on students.user_id = u.id
                               left join groups g on students.group_id = g.id
                               left join lessons l on g.id = l.group_id
                      where room_id = 5
                        and l.date between
                        (SELECT TIMESTAMP \'epoch\' + '.$start.' * INTERVAL \'1 second\')
                        and (SELECT TIMESTAMP \'epoch\' + '.$end.' * INTERVAL \'1 second\')
            )'
        );


    }
}
