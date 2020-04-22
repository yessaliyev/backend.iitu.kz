<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Schedule extends Model
{
    const TAKE_ATTENDANCE = 1;
    protected $fillable = [
        'subject_id',
        'subject_type_id',
        'group_id',
        'teacher_id',
        'appointment_id',
        'room_id',
        'day_id',
        'time_id'
    ];

    public static function validateRequest($request)
    {

        $request->validate([
            'subject_id'       => 'required|exists:subjects,id',
            'subject_type_id'  => 'required|exists:subject_types,id',
            'group_id'         => 'required|exists:groups,id',
            'teacher_id'       => 'required|exists:teachers,id',
            'appointment_id'   => 'required|exists:appointments,id',
            'room_id'          => 'required|exists:rooms,id',
            'day_id'           => 'required|exists:days,id',
            'time_id'          => 'required|exists:times,id'
        ]);

        $schedule = Schedule::where('group_id',$request->group_id)
            ->where('room_id', $request->room_id)
            ->where('time_id', $request->time_id)
            ->count();

        throw_if($schedule > 0, new HttpException(422,'already exists'));

        return true;

    }

    public static function create($request){
        $schedule = self::firstOrCreate([
            'subject_id' => $request->subject_id,
            'subject_type_id' => $request->subject_type_id,
            'group_id' => $request->group_id,
            'teacher_id' => $request->teacher_id,
            'appointment_id' => $request->appointment_id,
            'room_id' => $request->room_id,
            'day_id' => $request->day_id,
            'time_id' => $request->time_id
        ]);

        foreach (Week::all() as &$item){
            $schedule->weeks()->attach($item->id);
        }
    }

    public function weeks(){
        return $this->belongsToMany('App\Models\Schedule','schedules_weeks','schedules_id','weeks_id');
    }
}
