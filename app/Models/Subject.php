<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Schedule;

class Subject extends Model
{
    protected $fillable = [
        'name_en',
        'name_ru',
        'name_kk',
        'o_id',
    ];

    public function groups(){
        return $this->belongsToMany('App\Models\Group','schedules');
    }

    public static function attendance($group_id,$subject_id){
        $result = DB::table('weeks')
        ->leftJoin('schedules_weeks', 'schedules_weeks.weeks_id', '=', 'weeks.id')
        ->leftJoin('schedules','schedules.id','=','schedules_weeks.schedules_id')
        ->leftJoin('days','schedules.day_id','=','days.id')
        ->where('schedules.group_id','=',$group_id)
        ->where('weeks.status','=',Schedule::TAKE_ATTENDANCE)
        ->where('schedules.subject_id','=',$subject_id)
        ->get();

        foreach ($result as &$item){
            $item->date = self::getDate($item->start,$item->o_id);
        }

        return $result;
    }

    private static function getDate($start,$week_day){
        for ($i = 0; $i<6; $i++){
            if (date('w', strtotime($start)) != $week_day) {
                $start = date('Y-m-d', strtotime($start. ' + 1 days'));
            }
        }

        return $start;
    }
}
